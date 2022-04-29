<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FreshSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh in Your System';

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
        $this->call("down");

        $this->call("migrate:refresh", [
            "--seed" => true
        ]);

        $this->info("Your database has been created and new information has been uploaded");

        $this->call("event:clear");
        $this->call("view:clear");
        $this->call("optimize:clear");
        $this->call("package:discover");
        $this->call("event:clear");
        $this->call("config:clear");
        $this->call("optimize");
        $this->call("auth:clear-resets");
        $this->info("Remove all system caches");

        $this->call("up");

        return 0;
    }
}
