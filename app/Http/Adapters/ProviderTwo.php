<?php


namespace App\Http\Adapters;


use App\Http\Interfaces\ApiInterface;
use App\Models\Task;
use Illuminate\Support\Facades\Http;

class ProviderTwo implements ApiInterface
{

    protected $url;

    public function setUrl($url)
    {
        $this->url = $url;
        // TODO: Implement setUrl() method.
    }

    public function getTask()
    {
        $taskList = Http::get($this->url)->json();
        foreach ($taskList as $task){
            $newTask = new Task();
            $newTask->name = $task['id'];
            $newTask->level = $task['zorluk'];
            $newTask->estimated_duration = $task['sure'];
            $newTask->save();
        }
        echo 'All Tasks Recorded Successfully ! </br> ';
        // TODO: Implement getTask() method.
    }
}
