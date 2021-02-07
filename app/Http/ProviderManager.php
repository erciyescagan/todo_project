<?php


namespace App\Http;


use App\Http\Interfaces\ApiInterface;

class ProviderManager
{
    public function getTasksFromProviders(ApiInterface $provider, $url){
        $provider->setUrl($url);
        $provider->getTask();
    }
}
