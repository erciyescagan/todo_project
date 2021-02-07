<?php

namespace App\Console\Commands;

use App\Http\Interfaces\ApiInterface;
use App\Http\TodoManager;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:get {url} {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all tasks from provider';

    /**
     * @var array|string|null
     */
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
     * @return void
     */
    public function handle()
    {
        $url = $this->argument('url');
        $provider = '\App\Http\Adapters\\'. $this->argument('provider');
        $todoManager = new TodoManager();
        $todoManager->getTasksFromProviders(new $provider(), $url);
    }

}
