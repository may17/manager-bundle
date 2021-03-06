<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao\ManagerBundle\Api\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Dotenv\Dotenv;

class GetDotEnvCommand extends Command
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        parent::__construct();

        $this->projectDir = $projectDir;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        parent::configure();

        $this
            ->setName('dot-env:get')
            ->setDescription('Reads a parameter from the .env file.')
            ->addArgument('key', InputArgument::REQUIRED, 'The variable name')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $path = $this->projectDir.'/.env';

        if (!file_exists($path)) {
            return;
        }

        $vars = (new Dotenv())->parse(file_get_contents($path));
        $key = $input->getArgument('key');

        if (isset($vars[$key])) {
            $output->write($vars[$key]);
        }
    }
}
