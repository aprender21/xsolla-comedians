<?php

namespace App\Console\Commands;

use App\Models\Comedian;
use Illuminate\Console\Command;

class CreateDummyComedians extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comedians:create {count=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate database with dummy records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Comedian::factory()->count($this->argument('count'))->create();
    }
}
