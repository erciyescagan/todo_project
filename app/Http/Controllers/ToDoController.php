<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Task;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    public function index(){
        $tasks = Task::all();
        $developers = Developer::all();
        $tasksArr = [];
        $devlist = [];
        foreach ($tasks as $task){
            $tasksArr[$task->level][] = ['name' => $task->name, 'estimated_duration' => $task->estimated_duration, 'level' => $task->level];
        }
        krsort($tasksArr);

        foreach ($developers as $developer){
            if (array_key_exists($developer->level, $devlist)){
                array_push($devlist, $developer->level = ['name' => $developer->name, 'level' => (int)$developer->level, 'time' => 0]);
            } else {
                $devlist[$developer->level] = ['name' => $developer->name, 'level' => (int)$developer->level, 'time' => 0];
            }
        }
        foreach ($tasksArr as $level => $tasks){
            foreach ($tasks as $task){
                $developerLevel = self::devfortasks($devlist, $level);
                $devlist[$developerLevel]['tasks'][] = array_merge($task, ['level' => $level]);
                $devlist[$developerLevel]['time'] += $task['estimated_duration'];
            }
        }


        foreach ($devlist as $key => $developer) {
            $devlist[$key]['name'] = $developer['name'];
            $devlist[$key]['level'] = $developer['level'];
            $devlist[$key]['time'] = $developer['time'];
            $devlist[$key]['weekly'] = self::groupWeek($developer['tasks'], (int)$devlist[$key]['level']);
        }

        $finish = 0;
        foreach ($devlist as $key => $developer){
            $time = count($developer['weekly']);
            if ($time > $finish){
                $finish = $time;
            }
        }

        return view('index',['taskfordevelopers'=>$devlist,'finish'=>$finish]);

    }

    private static function devfortasks($developers, $level)
    {
        $developer = $developers[$level];
        ksort($developers);

        $index = array_search($level, array_keys($developers));

        $upperLevelDeveloper = array_slice($developers, $index + 1, 1, true);

        if ( ! isset($upperLevelDeveloper[$level + 1]['time'])) {
            return $level;
        } elseif ($developer['time'] <= $upperLevelDeveloper[$level + 1]['time']) {
            return $level;
        } else {

            $upperLevel = self::devfortasks($developers, $level + 1);

            if ($upperLevel == $level) {
                return $level;

            } else {
                return $upperLevel;
            }
        }

    }
    private static function groupWeek($tasks,$level)
    {

        $devlevel=$level;
        $weeklyTasks = [
            [
                'tasks' => [],
                'time'  => 0,
            ],
        ];

        foreach ($tasks as $task) {
            $taskTime = $task['estimated_duration'];

            foreach ($weeklyTasks as $key => $week) {

                if ($week['time'] < 45 && ($week['time'] + $taskTime) <= 45) {
                    if($task['level']==$devlevel){
                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time']    += $taskTime;
                    }
                    else{
                        $task['time']=($taskTime*$task['level'])/$devlevel;

                        $weeklyTasks[$key]['tasks'][] = $task;

                        $weeklyTasks[$key]['tasks']['time'] = ($taskTime*$task['level'])/$devlevel;
                        $weeklyTasks[$key]['time']    += ($taskTime*$task['level'])/$devlevel;

                    }

                    break;

                }

                if ($week['time'] < 45 && ($week['time'] + $taskTime) > 45) {

                    if($task['level']==$devlevel){

                        $time                         = 45 - $week['time'];
                        $taskTime                     -= $time;
                        $task['time']                 = $time;
                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time']    += $time;

                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];
                    }
                    else {

                        $time                         = 45 - $week['time'];
                        $taskTime                     -= $time;
                        $task['time']                 = $time;
                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time']    += $time;

                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];

                    }
                    break;

                }

                if ($week['time'] == 45 && isset($weeklyTasks[$key + 1])) {

                    continue;

                }

                if ($week['time'] == 45 && ! isset($weeklyTasks[$key + 1])) {

                    if($task['level']==$devlevel){
                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];}
                    else {
                        $task['time']  = ($taskTime*$task['level'])/$devlevel;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];
                    }




                    break;

                }





            }

        }

        return $weeklyTasks;

    }






}
