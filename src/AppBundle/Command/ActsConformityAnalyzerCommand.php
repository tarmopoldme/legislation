<?php

namespace AppBundle\Command;

use AppBundle\Classes\operations\ActsConformityAnalyzer;
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

        $analyzer = new ActsConformityAnalyzer($output);
        $analyzer
            ->setActs(
                ActQuery::create()
//                    ->setLimit(10)
                    ->find()
            )
            ->analyze()
        ;

        $output->writeln('Acts conformity analyze is done');
    }
}
