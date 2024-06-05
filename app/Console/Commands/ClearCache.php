<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear and cache the configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('cache:clear');
        $this->info('Cache cleared successfully.');

        $this->call('config:clear');
        $this->info('Configuration cache cleared successfully.');

        $this->call('config:cache');
        $this->info('Configuration cached successfully.');

        return 0;
    }
}
