<?php


namespace App\Http\Helpers;


use App\Models\Developer;
use App\Models\Task;

class ToDoHelper
{
    public function manageToDoPlanning(){
        $tasks = Task::all();
        $developers = Developer::all();
        self::tasksGroupByLevel($tasks);
        $finalDevlist = self::tasksAssignToDevelopersWithLevel($tasks, $developers, $devlist = []);
        $finish = self::calculateFinalResult($finalDevlist);
        return ['finalDevlist' => $finalDevlist, 'finish' => $finish];
    }

    private static function tasksGroupByLevel($tasks){

        foreach ($tasks as $task){
            $tasksArr[$task->level][] = ['name' => $task->name, 'estimated_duration' => $task->estimated_duration, 'level' => $task->level];
        }
        return $tasksArr;
    }

    private static function tasksAssignToDevelopersWithLevel($tasks, $developers, $devlist = []){

        $tasksArr = self::tasksGroupByLevel($tasks);
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
                $developerLevel = self::levelForTasks($devlist, $level);
                $devlist[$developerLevel]['tasks'][] = array_merge($task, ['level' => $level]);
                $devlist[$developerLevel]['time'] += $task['estimated_duration'];
            }
        }


        foreach ($devlist as $key => $developer) {
            $devlist[$key]['name'] = $developer['name'];
            $devlist[$key]['level'] = $developer['level'];
            $devlist[$key]['time'] = $developer['time'];
            $devlist[$key]['weekly'] = self::tasksGroupByWeek($developer['tasks'], (int)$devlist[$key]['level']);
        }

        return $devlist;
    }

    private static function levelForTasks($developers, $level)
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

            $upperLevel = self::levelForTasks($developers, $level + 1);

            if ($upperLevel == $level) {
                return $level;

            } else {
                return $upperLevel;
            }
        }

    }
    private static function tasksGroupByWeek($tasks,$level)
    {
        $weeklyTasks = [
            [
                'tasks' => [],
                'time'  => 0,
            ],
        ];

        foreach ($tasks as $task) {
            $taskTime = $task['estimated_duration'];

            foreach ($weeklyTasks as $key => $week) {

                if ($week['time'] < 45){
                    if (($week['time'] + $taskTime) <= 45) {
                        if($task['level']<=$level){
                            $weeklyTasks[$key]['tasks'][] = $task;
                            $weeklyTasks[$key]['time']    += $taskTime;
                        }

                        break;
                    } else if (($week['time'] + $taskTime) > 45){


                        $time = 45 - $week['time'];
                        $taskTime -= $time;
                        $task['time'] = $time;
                        $weeklyTasks[$key]['tasks'][] = $task;
                        $weeklyTasks[$key]['time'] += $time;

                        $task['time'] = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];

                    }

                } elseif ($week['time'] == 45){
                    if (isset($weeklyTasks[$key+1])){
                        continue;
                    } elseif (!isset($weeklyTasks[$key +1])){
                        $task['time']  = $taskTime;
                        $weeklyTasks[] = [
                            'tasks' => [$task],
                            'time'  => $task['time'],
                        ];
                    }
                }
            }

        }

        return $weeklyTasks;

    }

    private static function calculateFinalResult($devlist){
        $finish = 0;
        foreach ($devlist as $key => $developer){
            $time = count($developer['weekly']);
            if ($time > $finish){
                $finish = $time;
            }
        }
        return $finish;
    }
}
