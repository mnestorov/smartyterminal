<?php

namespace SmartyStudio\SmartyTerminal\Tests\Console\Commands;

use Illuminate\Container\Container;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use SmartyStudio\SmartyTerminal\Console\Commands\ArtisanTinker;

class ArtisanTinkerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @return void
     */
    public function test_echo()
    {
        $commandTester = $this->executeCommand('echo 123');

        self::assertStringContainsString('123', $this->lf($commandTester->getDisplay()));
    }

    /**
     * @return void
     */
    public function test_var_dump()
    {
        $commandTester = $this->executeCommand('var_dump(123)');

        self::assertStringContainsString('int(123)', $this->lf($commandTester->getDisplay()));
    }

    /**
     * @return void
     */
    public function test_show_object()
    {
        $commandTester = $this->executeCommand('new stdClass;');

        if (PHP_VERSION_ID >= 70300) {
            self::assertStringContainsString("=> (object) array(\n)\n", $this->lf($commandTester->getDisplay()));
        } else {
            self::assertStringContainsString("=> stdClass::__set_state(array(\n))\n", $this->lf($commandTester->getDisplay()));
        }
    }

    /**
     * @return void
     */
    public function test_show_array()
    {
        $commandTester = $this->executeCommand("['foo' => 'bar'];");

        self::assertSame("=> array (\n  'foo' => 'bar',\n)\n", $this->lf($commandTester->getDisplay()));
    }

    /**
     * @return void
     */
    public function testHandleString()
    {
        $commandTester = $this->executeCommand("'abc'");

        self::assertSame("=> abc\n", $this->lf($commandTester->getDisplay()));
    }

    /**
     * @return void
     */
    public function testNumeric()
    {
        $commandTester = $this->executeCommand('123');

        self::assertSame("=> 123\n", $this->lf($commandTester->getDisplay()));
    }

    /**
     * @param $content
     * @return array|string|string[]
     */
    protected function lf($content)
    {
        return str_replace("\r\n", "\n", $content);
    }

    /**
     * @param  string  $cmd
     * @return CommandTester
     */
    private function executeCommand($cmd)
    {
        $container = new Container;
        $command = new ArtisanTinker();
        $command->setLaravel($container);

        $commandTester = new CommandTester($command);
        $commandTester->execute(['--command' => $cmd]);

        return $commandTester;
    }
}
