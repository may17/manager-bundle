<?php

/*
 * This file is part of Contao.
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Contao\ManagerBundle\API\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Andreas Schempp <https://github.com/aschempp>
 */
class ListConfigCommand extends Command
{
    protected function configure()
    {
        parent::configure();

        $this->setName('config:list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO implement ListConfigCommand
    }
}
