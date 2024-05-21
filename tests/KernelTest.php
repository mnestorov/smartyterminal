<?php

namespace SmartyStudio\SmartyTerminal\Tests;

use Exception;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use SmartyStudio\SmartyTerminal\Console\Application;
use SmartyStudio\SmartyTerminal\Console\Kernel;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class KernelTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @throws Exception
     */
    public function test_handle_method()
    {
        $container = new Container();
        $request = Request::capture();
        $container->instance('request', $request);
        $artisan = new Application($container, new Dispatcher(), 'testing');
        $input = new ArrayInput([]);
        $output = new BufferedOutput();
        $kernel = new Kernel($artisan);

        self::assertSame(0, $kernel->handle($input, $output));
    }

    /**
     * @return Kernel[]
     */
    public function test_call_method()
    {
        $container = new Container();
        $request = Request::capture();
        $container->instance('request', $request);
        $artisan = new Application($container, new Dispatcher(), 'testing');
        $output = new BufferedOutput();
        $kernel = new Kernel($artisan);
        self::assertSame(0, $kernel->call('help', ['list'], $output));

        return [$kernel];
    }

    /**
     * @depends test_call_method
     * @param array $parameters
     * @return void
     */
    public function test_output_method(array $parameters)
    {
        $kernel = $parameters[0];

        self::assertStringContainsString('--raw', $kernel->output());
    }

    /**
     * @return void
     */
    public function test_queue_method_and_laravel_version_less_then_54()
    {
        $container = new Container();
        $request = Request::capture();
        $container->instance('request', $request);
        $queue = m::spy(Queue::class);
        $container->instance(Queue::class, $queue);
        $artisan = new Application($container, new Dispatcher(), '5.3.9');
        $kernel = new Kernel($artisan);
        $command = 'help';
        $parameters = ['list'];
        $kernel->queue($command, $parameters);
        $queue->shouldHaveReceived('push')
            ->with('Illuminate\Foundation\Console\QueuedJob', m::on(function ($args) use ($command, $parameters) {
                return [$command, $parameters] === $args;
            }));
    }

    /**
     * @return void
     */
    public function test_all_method()
    {
        $artisan = new Application(new Container(), new Dispatcher(), 'testing');
        $kernel = new Kernel($artisan);
        self::assertArrayHasKey('help', $kernel->all());
    }

    /**
     * @return void
     */
    public function test_terminate_method()
    {
        $artisan = m::spy(new Application(new Container(), new Dispatcher(), 'testing'));
        $kernel = new Kernel($artisan);
        $input = new ArrayInput([]);
        $kernel->terminate($input, 0);
        $artisan->shouldHaveReceived('terminate');
    }
}
