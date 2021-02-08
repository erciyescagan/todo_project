<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To Do Planner</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>
<body style="text-align:center;margin-top: 20px;">
<div class="card">
    <div class="card-header" id="headingOne">
        <h5 class="mb-0">
            Tüm İşlerin {{$finallyWeekCount}} Haftada Bitmesini Sağlayacak İş Planı Aşağıdaki Tablolarda Verilmiştir.
        </h5>
        <p style="margin-top: 15px">Her developer için 5 haftalık iş planı oluşturulmuştur.</p>
    </div>
</div>
<div style="text-align: center">
    @foreach($tasksForDevelopers as $tasksForDeveloperKey => $tasksForDeveloper)
        <div style="padding:20px;margin-top:50px;border: 1px solid darkred" class="col-md-12">
            <h3 style="text-align: center">Developer {{$tasksForDeveloperKey}}</h3>
            <h5 style="text-align: center">Developer Level :{{$tasksForDeveloper['level']}}</h5>
            <h5 style="text-align: center">Total Working Hours : {{ $tasksForDeveloper['time'] }}</h5>
        </div>
        <div class="row">
            @foreach($tasksForDeveloper['weekly'] as $tasksKey => $tasks)
                <div style="margin-top: 20px" class="col-md-12"><h5>Week {{$tasksKey + 1}}</h5></div>
                <table style="margin:5px 5px;border: 1px solid #f1f1f1" class="table col-md-12">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Task Name</th>
                        <th>Estimated Duration</th>
                        <th>Level</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $weeklyWorkingHour = 0;
                        ?>
                    @foreach($tasks['tasks'] as $taskKey => $task)

                        @if(isset($task['level']))
                            <tr>
                                <td>{{$taskKey}}</td>
                                <td>{{$task['name']}}</td>
                                <td>@if(isset($task['time'])){{$task['time']}} @else {{$task['estimated_duration']}} @endif</td>
                                <td>{{$task['level']}}</td>
                            </tr>
                            <?php
                            $weeklyWorkingHour += isset($task['time']) ? $task['time'] : $task['estimated_duration'] ;
                            ?>
                            @endif

                    @endforeach
                    </tbody>
                </table>
                <div style="background-color: #91de83;" class="col-md-12">
                    <strong>Weekly Working Hour : </strong> <span>{{$weeklyWorkingHour}}</span><br>
                    <strong>Total Job Count :</strong> <span>{{count($tasks['tasks'])}}</span>
                </div>

            @endforeach

        </div>
    @endforeach

</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
