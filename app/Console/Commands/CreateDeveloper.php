<?php

namespace App\Console\Commands;

use App\Models\Developer;
use Illuminate\Console\Command;

class CreateDeveloper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'developer:create {--name=} {--level=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new developer with name and level';

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
        $name = $this->option('name');
        $level = $this->option('level');
        $developer = new Developer();
        $developer->name = $name;
        $developer->level = $level;
        $developer->time = 1;
        $developer->save();
        return 0;
    }
}
