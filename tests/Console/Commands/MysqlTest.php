<?php

namespace SmartyStudio\SmartyTerminal\Tests\Console\Commands;

use Illuminate\Container\Container;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use SmartyStudio\SmartyTerminal\Console\Commands\Mysql;

class MysqlTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @return void
     */
    public function testHandle()
    {
        $container = m::mock(new Container);
        Container::setInstance($container);
        $sql = 'SELECT * FROM users;';
        $databaseManager = m::mock(DatabaseManager::class);
        $connection = m::mock(ConnectionInterface::class);
        $databaseManager->shouldReceive('connection')->once()->with('mysql')->andReturn($connection);
        $connection->shouldReceive('select')->once()->with($sql, [], true)->andReturn($rows = [
            ['name' => 'smartystudio', 'email' => 'support@smartystudio.net'],
        ]);

        $command = new Mysql($databaseManager);
        $command->setLaravel($container);

        $commandTester = new CommandTester($command);
        $commandTester->execute(['--command' => $sql, '--connection' => 'mysql']);

        self::assertStringContainsString('support@smartystudio.net', $commandTester->getDisplay());
    }
}
