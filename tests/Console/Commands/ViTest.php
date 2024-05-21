<?php

namespace SmartyStudio\SmartyTerminal\Tests\Console\Commands;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use SmartyStudio\SmartyTerminal\Console\Commands\Vi;

class ViTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @return void
     */
    public function test_read()
    {
        $files = m::mock(Filesystem::class);
        $files->shouldReceive('get')->with('foo/foo')->andReturn($text = 'foo');

        $command = new Vi($files);
        $command->setLaravel($this->getContainer());

        $commandTester = new CommandTester($command);
        $commandTester->execute(['path' => 'foo']);

        self::assertStringContainsString($text, $commandTester->getDisplay());
    }

    /**
     * @return void
     */
    public function testHandleWrite()
    {
        $text = 'foo';
        $files = m::spy(Filesystem::class);

        $command = new Vi($files);
        $command->setLaravel($this->getContainer());

        $commandTester = new CommandTester($command);
        $commandTester->execute(['path' => 'foo', '--text' => $text]);

        $files->shouldHaveReceived('put')->with('foo/foo', $text)->once();
    }

    /**
     * @return Container
     */
    private function getContainer()
    {
        $container = m::mock(new Container());
        $container->shouldReceive('basePath')->andReturn('foo/');
        Container::setInstance($container);

        return $container;
    }
}
