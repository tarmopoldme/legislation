<?php

namespace AppBundle\Command;

use AlgoliaSearch\AlgoliaException;
use AlgoliaSearch\Client;
use AlgoliaSearch\Index;
use AppBundle\Model\Act;
use AppBundle\Model\ActQuery;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to inded
 * @author <tarmo.poldme@brainart.ee>
 * @date 15.04.2017
 */
class ActsAlgoliaIndexCommand extends ContainerAwareCommand
{
    /**
     * Index text max length in bytes
     */
    const INDEX_TEXT_MAX_LENGTH = 80000;

    protected function configure()
    {
        $this
            ->setName('legislation:algolia:index')
            ->setDescription('Index local database to Algolia')
        ;
    }

    /**
     * TODO refactor to separate indexer object
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        require_once __DIR__ . '/../Classes/algoliasearch/algoliasearch.php';

        $output->writeln('Starting acts indexing');

        $appId = $this->getContainer()->getParameter('legislation.algolia.app_id');
        $adminApiKey = $this->getContainer()->getParameter('legislation.algolia.admin_api_key');

        $client = new Client($appId, $adminApiKey);
        $index = $client->initIndex('legislation');
        $index->clearIndex();

        $acts = ActQuery::create()
            ->find()
        ;
        foreach ($acts as $act) {
            $output->writeln('Indexing act ' . $act->getName());
            $xml = @simplexml_load_string($act->getXml());

            if (!empty($xml->sisu[0]->osa) && count($xml->sisu[0]->osa) > 1) {
                foreach ($xml->sisu[0]->osa as $part) {
                    foreach ($part->peatykk as $chapter) {
                        $content = strip_tags($chapter->asXML());
                        $chapterText = trim(preg_replace('!\s+!', ' ', $content));
                        $this->addToIndex($index, $act, $chapterText, $output);
                    }
                }
            } elseif (!empty($xml->sisu[0]->peatykk)) {
                foreach ($xml->sisu[0]->peatykk as $chapter) {
                    $content = strip_tags($chapter->asXML());
                    $chapterText = trim(preg_replace('!\s+!', ' ', $content));
                    $this->addToIndex($index, $act, $chapterText, $output);
                }
            } else {
                $content = strip_tags($xml->sisu->asXML());
                $contentText = trim(preg_replace('!\s+!', ' ', $content));
                $this->addToIndex($index, $act, $contentText, $output);
            }
        }

        $index->setSettings([
            'attributeForDistinct' => 'name'
        ]);

        $output->writeln('Acts indexing complete');
    }

    /**
     * @param Index $index
     * @param Act $act
     * @param string $text
     * @param OutputInterface $output
     */
    private function addToIndex(Index $index, Act $act, $text, OutputInterface$output)
    {
        if (strlen($text) > self::INDEX_TEXT_MAX_LENGTH) {
            $words = explode(' ', $text);
            $tmpText = '';
            foreach ($words as $key => $word) {
                $tmpText .= $word . ' ';
                unset($words[$key]);
                if (strlen($tmpText) > self::INDEX_TEXT_MAX_LENGTH) {
                    break;
                }
            }
            $texts = [trim($tmpText)];
            if (!empty($words)) {
                $tmpText = join(' ', $words);
                $texts[] = $tmpText;
            }
        }

        if (!isset($texts)) {
            $texts = [$text];
        }
        foreach ($texts as $text) {
            try {
                $index->addObject([
                    'name' => $act->getName(),
                    'text' => $text,
                    'url' => $act->getUrl(),
                    'weight' => $act->getCombinedWeight()
                ]);
            } catch (AlgoliaException $e) {
                $output->writeln($e->getMessage());
            }
        }
    }
}
