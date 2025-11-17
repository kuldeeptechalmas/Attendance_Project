<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/user/style.css') }}">
    <title>TechSoft</title>

</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white" style="height: 85px;">
        <div class="container-fluid">

            <a class="navbar-brand text-primary" href="{{ route('user.Dashboard') }}" style="margin-left: 18px;">
                <img style="height: 42px;" src="{{ asset('images/logo.png') }}" alt="">
                TechSoft</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" style="position: relative;" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <h1><button class="btn btn-primary" id="maindiv" onclick="demofun()">Just Test</button></h1>
                </ul>
                <div id="showdivples" style="position: absolute;top: 105%;width: 26%;background: wheat;display: none;">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
                <form class="d-flex" role="search">
                    <div class="profilediv">
                        {{ Str::upper(value: (substr(Auth::user()->name,0,2))) }}
                        <div class="profiledivinfo">
                            <div class="profiledivinfo_inner">
                                <div style="display: flex;justify-content: center;padding-top: 20px;">
                                    <div class="floatdivchar">
                                        {{ Str::upper(value: (substr(Auth::user()->name,0,2))) }}
                                    </div>
                                </div>
                                <div class="mx-4" style="color: black;font-size: 16px;text-align: center;margin-top: 17px;">
                                    <span>
                                        {{ Auth::user()->name }}
                                    </span>
                                    <br>
                                    <span class="mt-5">
                                        {{ Auth::user()->email }}
                                    </span>
                                    <hr>
                                </div>
                                <div class="text-dark mx-4" style="font-size: 18px;">
                                    <a href="{{ route('user.profile') }}" style="color: black;text-decoration: none;">
                                        <i class="fa-solid fa-user"></i> Profile
                                    </a>
                                    <hr>
                                </div>
                                <div class="text-dark mx-4" style="font-size: 18px;">
                                    <a href="{{ route('user.logout') }}" style="color: red;text-decoration: none;">
                                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div class="row mt-3">
        <div class="col-3 bg-white" style="height: 435px;">
            <h5 style="margin: 25px;">
                Hi, 👋 <br>
                Welcome To <br>
                {{ Auth::user()->roles }} <br>
            </h5>
            @if (Auth::user()->roles=='Employee' || Auth::user()->roles=='HR')
            <div style="padding:10px 25px;">
                <a href="/Month-Attendance/{{ Auth::user()->id }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Month Attendance
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('teams') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Teams
                </a>
            </div>
            @endif
            @if (Auth::user()->roles=='HR')
            <div style="padding:10px 25px;">
                <a href="{{ route('hrget.employee.data') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Employees
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('add.attendance.employee',['userid'=>Auth::user()->id]) }}">

                    <input type="button" class="btn btn-primary" value="Add Attendance HR">
                </a>
            </div>
            @endif
            @if (Auth::user()->roles=='Admin')
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.employee.manage') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Employee
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.hr.manage') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    HR
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.add') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Add Employee,HR
                </a>
            </div>
            @endif
            @if (Auth::user()->roles=='Super Admin')
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.employee.manage') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Employee
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.hr.manage') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    HR
                </a>
            </div>


            <div style="padding:10px 25px;">
                <a href="{{ route('superadmin.show.admin') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Admin
                </a>
            </div>

            <div style="padding:10px 25px;">
                <a href="{{ route('admin.add') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Add Employee,HR,Admin
                </a>
            </div>

            @endif
        </div>
        <div class="col-9">
            @if (isset($dashboard))
            @if (Auth::user()->roles=='Employee' || Auth::user()->roles=='HR')


            @if ($attendance->isNotEmpty())

            <div>Today Attendance</div>
            <div class="row" style="margin-left: 0px;margin-right: 5px;">
                @foreach ($attendance as $item)
                <div class="row attendanceshow">

                    <div class="col-4">
                        {{ $item->date }}
                    </div>
                    <div class="col-4">
                        @php
                        $totalHover = 0;
                        $totalMinute = 0;
                        @endphp
                        @foreach ($item->checkinoutdataget as $check)
                        @if ($check->check_out_time!='00:00:00')

                        @php

                        $time1 = now()::parse($check->check_in_time);
                        $time2 = now()::parse($check->check_out_time);
                        $diffrence = $time1->diff($time2);
                        $totalHover+=$diffrence->h;
                        $totalMinute+=$diffrence->i;

                        @endphp

                        @endif
                        @endforeach
                        @php
                        if($totalMinute>=60)
                        {
                        $totalHover+=1;
                        $totalMinute-=60;
                        }
                        @endphp
                        <div id="changetime">
                            {{$totalHover }}:{{ $totalMinute }}
                        </div>
                    </div>
                    <div class="col-4" style="display: flex;justify-content: end;padding-right: 34px;">

                    </div>
                    <div style="margin-top: 20px;margin-bottom: 10px;margin-left: 33px;">
                        TimeSheet Date <br>
                        @foreach ($item->checkinoutdataget as $check)
                        <input type="text" name="" value="{{ $item->id }}" id="" hidden>
                        <input style="margin: 14px 12px 10px 12px;" disabled type="time" name="checkintime" value="{{ $check->check_in_time }}" id="checkintime">
                        <input type="text" name="id" id="checkid" value="{{ $check->id }}" hidden>
                        <input style="margin: 14px 12px 10px 12px;" type="time" disabled name="checkouttime" value="{{ $check->check_out_time }}" id="checkouttime">
                        <input type="text" name="" value="{{ $item->id }}" id="" hidden>
                        <br>
                        @endforeach

                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="display: flex;justify-content: center;font-size: 19px;margin-top: 133px;">
                <div style="background: white;width: 267px;display: flex;justify-content: center;">
                    Today Attendance is Not Found
                </div>
            </div>
            @endif
            @endif
            @if (Auth::user()->roles=='Admin' || Auth::user()->roles=='Super Admin')
            @if (isset($dashboard))
            <div style="background-color: white;padding: 10px 23px;">
                <div style="font-size: 22px;">
                    Welcome,<br>
                    To TechSoft<br>
                    All Members
                </div>

                <div style="text-align: center;">
                    <h3>
                        TechSoft LLT.
                    </h3>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Index.</td>
                        <td>Name</td>
                        <td>Totals</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Employees</td>
                        <td> {{ $countemployee }}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>HR</td>
                        <td> {{ $counthr }}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Admin</td>
                        <td> {{ $countadmin }}</td>
                    </tr>
                </table>

            </div>

            @endif
            @endif
            @else

            @yield('content')
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const demofun = () => {

            console.log($('#showdivples').css({
                "display": "block"
            , }));

        }

        const myDiv = document.getElementById('showdivples');
        const myDivmain = document.getElementById('maindiv');
        document.addEventListener('click', function(event) {
            if (!myDiv.contains(event.target) && event.target !== myDiv && event.target !== myDivmain) {
                myDiv.style.display = 'none';
            }
        });

        function checkintimes(e) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
                , type: "post"
                , url: "{{ route('checkin.time.change') }}"
                , data: {
                    checkinid: $($(e).next()[0]).val()
                    , checkintime: $(e).val()
                    , attendanceid: $($(e).prev()[0]).val()
                }
                , success: function(res) {

                    $("#changetime").html(res['hover'] + ":" + res['minute'])
                }
                , error: function() {

                }
            });
        }

        function checkouttimes(e) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
                , type: "post"
                , url: "{{ route('checkout.time.change') }}"
                , data: {
                    checkinid: $($(e).prev()[0]).val()
                    , checkouttime: $(e).val()
                    , attendanceid: $($(e).next()[0]).val()
                }
                , success: function(res) {
                    $("#changetime").html(res['hover'] + ":" + res['minute'])
                }
                , error: function() {

                }
            });
        }

    </script>
</body>
</html>
