<?php


namespace App\Http;


use App\Http\Interfaces\ApiInterface;

class TodoManager
{
    public function getTasksFromProviders(ApiInterface $provider, $url){
        $provider->setUrl($url);
        $provider->getTask();
    }
}
