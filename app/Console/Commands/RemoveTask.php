<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class RemoveTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:remove {--task_name=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all tasks from database';

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
        $task_name = $this->option('task_name');
        if ($task_name && $task_name != 'all'){
            Task::where('name', $task_name)->first()->delete();
            echo $task_name.' Removed Successfully ! <br/>';
        } elseif ($task_name && $task_name == 'all'){
            Task::query()->delete();
            echo 'All Tasks Removed Successfully ! <br/>';
        }
    }
}
