<?php

namespace Contao\ManagerBundle\API;

use Contao\ManagerBundle\API\Command\GetPackagesCommand;
use Contao\ManagerBundle\API\Command\GetConfigCommand;
use Contao\ManagerBundle\API\Command\ListConfigCommand;
use Contao\ManagerBundle\API\Command\SetPackagesCommand;
use Contao\ManagerBundle\API\Command\SetConfigCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ContaoApi extends Application
{
    const VERSION = '1.0.0';

    public function __construct()
    {
        parent::__construct('contao-api', self::VERSION);
    }

    protected function configureIO(InputInterface $input, OutputInterface $output)
    {
        $output->setDecorated(false);
        $input->setInteractive(false);
    }

    protected function getDefaultInputDefinition()
    {
        return new InputDefinition(
            [
                new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
            ]
        );
    }

    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();

        $commands[] = new ListConfigCommand();
        $commands[] = new GetConfigCommand();
        $commands[] = new SetConfigCommand();
        $commands[] = new GetPackagesCommand();
        $commands[] = new SetPackagesCommand();

        return $commands;
    }
}
