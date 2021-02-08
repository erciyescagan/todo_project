<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ToDoHelper;
use App\Models\Developer;
use App\Models\Task;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function index(){
        $toDoHelper = new ToDoHelper();
        $result = $toDoHelper->manageToDoPlanning();
        $finallyWeekCount = $result['finish'];
        $tasksForDevelopers = $result['finalDevlist'];

        return view('index', ['tasksForDevelopers' => $tasksForDevelopers, 'finallyWeekCount' => $finallyWeekCount]);
    }







}
