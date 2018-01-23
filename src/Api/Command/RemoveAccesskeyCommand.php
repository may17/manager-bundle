<?php

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\ManagerBundle\Api\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class RemoveAccesskeyCommand extends Command
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
            ->setName('access-key:remove')
            ->setDescription('Removes the debug access key.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $fs = new Filesystem();
        $path = $this->projectDir.'/.env';

        if (!$fs->exists($path)) {
            return;
        }

        $content = '';
        $lines = file($path, FILE_IGNORE_NEW_LINES);

        if (false === $lines) {
            throw new \RuntimeException(sprintf('Could not read "%s" file.', $path));
        }

        foreach ($lines as $line) {
            if (0 === strncmp($line, 'APP_DEV_ACCESSKEY=', 18)) {
                continue;
            }

            $content .= $line."\n";
        }

        if (empty($content)) {
            $fs->remove($path);
        } else {
            $fs->dumpFile($path, $content);
        }
    }
}
