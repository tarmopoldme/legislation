<?php

namespace AppBundle\Command;

use AppBundle\Model\Base\ActQuery;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  Acts conformity analyzer
 * @author <tarmo.poldme@brainart.ee>
 * @date 26.02.2017
 */
class ActsConformityAnalyzerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('legislation:acts:analyze-confirmity')
            ->setDescription('Find confirmity weights for acts')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit','2048M');

        $output->writeln('Starting acts conformity analyze');

        $analyzer = $this->getContainer()->get('legislation.acts_conformity_analyzer');
        $analyzer
            ->setActs(ActQuery::create()->find())
            ->analyze()
        ;

        $output->writeln('Acts conformity analyze is done');
    }
}
