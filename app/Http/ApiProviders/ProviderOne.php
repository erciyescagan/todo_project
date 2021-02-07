<?php


namespace App\Http\ApiProviders;


use App\Http\Interfaces\ApiInterface;
use App\Models\Task;
use http\Env\Request;
use Illuminate\Support\Facades\Http;

class ProviderOne implements ApiInterface
{

    protected $url;

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getTask()
    {
        $taskLists = Http::get($this->url)->json();
        foreach ($taskLists as $taskList) {
            foreach ($taskList as $key => $task) {
                $newTask = new Task();
                $newTask->name = $key;
                $newTask->level = $task['level'];
                $newTask->estimated_duration = $task['estimated_duration'];
                $newTask->save();
            }
        }
        echo 'All Tasks Recorded Successfully ! </br> ';
    }
}
