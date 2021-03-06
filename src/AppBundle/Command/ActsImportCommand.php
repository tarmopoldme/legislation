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
class ActsImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('legislation:acts:import')
            ->setDescription('Import Riigiteataja acts')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting acts import');
        $importer = $this->getContainer()->get('legislation.acts_importer');
        $importer->purgeDatabase();
        $importer->import();
        $output->writeln('Acts import complete');
    }
}
