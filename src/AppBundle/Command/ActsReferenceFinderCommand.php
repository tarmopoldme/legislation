<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  Acts import command
 * @author <tarmo.poldme@brainart.ee>
 * @date 04.02.2017
 */
class ActsReferenceFinderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('legislation:acts:find-references')
            ->setDescription('Find references for imported acts')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting acts reference finding');
        $referenceFinder = $this->getContainer()->get('legislation.acts_reference_finder');
        $referenceFinder->purgeOldReferences();
        $referenceFinder->find();
        ;
        $output->writeln('Acts reference finding is done');
    }
}
