@php
use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>TechSoft</title>
    <style>
        .profilediv {
            height: 45px;
            background-color: #2800ff;
            width: 51px;
            border-radius: 10px;
            margin-right: 20px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 21px;
            position: relative;
        }

        .profiledivinfo {
            position: absolute;
            top: 45px;
            right: -5px;
            display: none;
            border-top: 10px solid white;
        }

        .profilediv:hover .profiledivinfo {
            display: block;
        }

        .profiledivinfo_inner {
            background: white;
            border-radius: 22px;
            box-shadow: 1px 1px 7px black;
            height: 306px;
            width: 288px;
        }

        .floatdivchar {
            height: 80px;
            width: 80px;
            background-color: #2800ff;
            border-radius: 13px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
        }

        .attendanceshow {
            padding-bottom: 16px;
            margin-left: 0px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            width: 98%;
            margin-top: 27px;
            padding-top: 20px;
        }

    </style>
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
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if (Auth::user()->roles=='HR')

                    <li class="nav-item">
                        <a href="{{ route('hrget.employee.data') }}" style="margin-bottom: 7px;" class="nav-link active">Employees</a>
                    </li>
                    @endif
                    {{-- <li class="nav-item">
                        <a class="nav-link active">Link</a>
                    </li> --}}
                </ul>
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
            <div style="padding:10px 25px;">
                <a href="{{ route('month.attendance') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Month Attendance
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('teams') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Teams
                </a>
            </div>
        </div>
        <div class="col-9">
            @if (isset($dashboard))


            <div style="width: 98%;box-shadow: 1px 1px 4px #716c6c;">
                <div class="row">
                    {{-- <div class="col-4">
                            <div style="height: 50%;">
                                Time
                            </div>
                            <div style="height: 50%;padding: 0px 12px 9px 16px;">
                                <button type="button" class="btn" style="background-color: #f44336;color: white;height: 100%;width: 100%;">STOP</button>
                                <button type="button" class="btn" style="background-color: blue;color: white;height: 100%;width: 100%;">START</button>
                            </div>
                        </div> --}}

                    <div class="col-6">
                        <div style="display: flex;justify-content: center;">
                            @if (Session::get('checkin'))

                            <button class="btn btn-primary" disabled style="font-size: 29px;font-family: initial;height: 69px;margin: 10px;display: flex;justify-content: center;align-items: center;">
                                Check In
                            </button>
                            @else

                            <a href="{{ route('attendance.checkin') }}" style="text-decoration: none;">
                                <button class="btn btn-primary" style="font-size: 29px;font-family: initial;height: 69px;margin: 10px;display: flex;justify-content: center;align-items: center;">
                                    Check In
                                </button>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="display: flex;justify-content: center;">
                            @if (Session::get('checkin'))

                            <a href="{{ route('attendance.checkout') }}" style="text-decoration: none;">
                                <button class="btn btn-danger" style="font-size: 29px;font-family: initial;height: 69px;margin: 10px;display: flex;justify-content: center;align-items: center;">
                                    Check Out
                                </button>
                            </a>

                            @else
                            <button class="btn btn-danger" style="font-size: 29px;font-family: initial;height: 69px;margin: 10px;display: flex;justify-content: center;align-items: center;">
                                Check Out
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

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

                        $time1 = Carbon::parse($check->check_in_time);
                        $time2 = Carbon::parse($check->check_out_time);
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
                        <a href="/Attendance-Delete/{{ $item->id }}" style="color:red;text-decoration: none;">
                            <span>Remove</span>
                        </a>
                    </div>
                    <div style="margin-top: 20px;margin-bottom: 10px;margin-left: 33px;">
                        TimeSheet Date <br>
                        @foreach ($item->checkinoutdataget as $check)
                        <input type="text" name="" value="{{ $item->id }}" id="" hidden>
                        <input style="margin: 14px 12px 10px 12px;" onchange="checkintimes(this)" type="time" name="checkintime" value="{{ $check->check_in_time }}" id="checkintime">
                        <input type="text" name="id" id="checkid" value="{{ $check->id }}" hidden>
                        <input style="margin: 14px 12px 10px 12px;" onchange="checkouttimes(this)" type="time" name="checkouttime" value="{{ $check->check_out_time }}" id="checkouttime">
                        <input type="text" name="" value="{{ $item->id }}" id="" hidden>
                        <a href="/Check-Delete/{{ $check->id }}" style="margin-left: 312px;text-decoration: none;color:red">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        <br>
                        @endforeach

                    </div>
                </div>
                @endforeach
            </div>
            @else

            @yield('content')
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function checkintimes(e) {
            console.log($(e).val());
            console.log($($(e).next()[0]).val());

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
                    console.log(res['hover']);
                    console.log(res['minute']);

                    $("#changetime").html(res['hover'] + ":" + res['minute'])
                }
                , error: function() {

                }
            });
        }

        function checkouttimes(e) {
            console.log($(e).val());
            console.log($($(e).prev()[0]).val());

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
                    console.log(res['hover']);
                    console.log(res['minute']);
                    $("#changetime").html(res['hover'] + ":" + res['minute'])
                }
                , error: function() {

                }
            });
        }

    </script>
</body>
</html>
