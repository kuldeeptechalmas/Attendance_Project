<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
</head>
<body>
    <div style="display: flex;">
        <h1 style="text-align: center;">SoftTech LLT</h1>
    </div>
    <div style="margin-left: 13%;">

        <div style="margin: 30px;font-size: 18px;">
            Employee Name : {{ $data['name'] }}
        </div>
        <div style="margin: 30px;font-size: 18px;">
            Phone No : {{ $data['phone'] }}
        </div>
        <div style="margin: 30px;font-size: 18px;">
            Months : {{ $data['startdate'] }} To {{ $data['enddate'] }}
        </div>
        <div style="margin: 30px;font-size: 18px;">
            Hourse : {{ $data['hourse'] }}
        </div>
        <div style="margin: 30px;font-size: 18px;">
            Holy Day : {{ $data['leavesday'] }} Day
        </div>
        <div style="margin: 30px;font-size: 18px;">
            Working Day : {{ $data['workingday'] }} Day
        </div>
        <div style="margin: 30px;font-size: 18px;">
            Salary : {{ round($data['salary'],2) }}
        </div>
    </div>
</body>
</html>
