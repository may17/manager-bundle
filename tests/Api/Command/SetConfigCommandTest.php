<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace Contao\ManagerBundle\Tests\Api\Command;

use Contao\ManagerBundle\Api\Command\SetConfigCommand;
use Contao\ManagerBundle\Api\ManagerConfig;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class SetConfigCommandTest extends TestCase
{
    /**
     * @var ManagerConfig|MockObject
     */
    private $config;

    /**
     * @var SetConfigCommand
     */
    private $command;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->config = $this->createMock(ManagerConfig::class);
        $this->command = new SetConfigCommand($this->config);
    }

    public function testInstantiation(): void
    {
        $this->assertInstanceOf('Contao\ManagerBundle\Api\Command\SetConfigCommand', $this->command);
    }

    public function testHasCorrectNameAndArguments(): void
    {
        $this->assertSame('config:set', $this->command->getName());
        $this->assertTrue($this->command->getDefinition()->hasArgument('json'));
        $this->assertTrue($this->command->getDefinition()->getArgument('json')->isRequired());
    }

    public function testWritesManagerConfigFromJson(): void
    {
        $this->config
            ->expects($this->once())
            ->method('write')
            ->with(['foo' => 'bar'])
        ;

        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['json' => '{"foo":"bar"}']);

        $this->assertSame(0, $commandTester->getStatusCode());
    }

    public function testThrowsExceptionWhenJsonIsInvalid(): void
    {
        $commandTester = new CommandTester($this->command);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid JSON:');

        $commandTester->execute(['json' => 'foobar']);

        $this->assertSame(0, $commandTester->getStatusCode());
    }
}
