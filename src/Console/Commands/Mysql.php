<?php

namespace SmartyStudio\SmartyTerminal\Console\Commands;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use stdClass;
use Symfony\Component\Console\Input\InputOption;

class Mysql extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run MySQL console';

    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $databaseManager;

    /**
     * @param  DatabaseManager  $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        parent::__construct();
        $this->databaseManager = $databaseManager;
    }

    /**
     * Handle the command.
     *
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        $sql = $this->option('command');
        $connection = $this->databaseManager->connection($this->option('connection'));
        $rows = $this->castArray($connection->select($sql, [], true));
        $headers = array_keys(Arr::get($rows, 0, []));
        $this->table($headers, $rows);
    }

    /**
     * castArray.
     *
     * @param stdClass[] $rows
     * @return array[]
     */
    protected function castArray($rows): array
    {
        return array_map(static function ($row) {
            return (array) $row;
        }, $rows);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['command', null, InputOption::VALUE_REQUIRED],
            ['connection', null, InputOption::VALUE_OPTIONAL],
        ];
    }
}
