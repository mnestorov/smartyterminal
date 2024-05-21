<?php

namespace SmartyStudio\SmartyTerminal\Console\Commands;

use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class ArtisanTinker extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tinker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Tinker is a powerful REPL for the Laravel framework';

    /**
     * @throws InvalidArgumentException
     */
    public function handle()
    {
        $command = $this->option('command');

        ob_start();
        $result = $this->executeCode(
            trim(trim($command), ';').';'
        );
        $output = ob_get_clean();

        if (empty($output) === false) {
            $this->line($output);
            $result = null;
        }

        $this->getOutput()->write('=> ');
        switch (gettype($result)) {
            case 'object':
            case 'array':
                $this->line(var_export($result, true));
                break;
            case 'string':
                $this->comment($result);
                break;
            case 'NULL':
                $this->line('');
                break;
            default:
                is_numeric($result) === true ? $this->info($result) : $this->line($result);
                break;
        }
    }

    /**
     * @param string $code
     * @return string
     */
    protected function executeCode(string $code): string
    {
        $result = null;

        if (!str_contains($code, 'echo') && !str_contains($code, 'var_dump')) {
            $code = 'return '.$code;
        }

        $tmpName = tempnam(sys_get_temp_dir(), 'artisan-thinker');
        $handle = fopen($tmpName, 'w+');
        fwrite($handle, "<?php\n".$code);
        fclose($handle);
        $result = require $tmpName;
        unlink($tmpName);

        return $result;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [['command', null, InputOption::VALUE_REQUIRED],];
    }
}
