<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchAndStoreCountries;


class FetchCountriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch country Api To Database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FetchAndStoreCountries::dispatch();
    }
}
