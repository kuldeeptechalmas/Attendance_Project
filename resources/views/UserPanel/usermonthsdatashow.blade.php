@php
use Carbon\Carbon;
@endphp
@extends('UserPanel/userindex')

@section('content')
<div class="row" style="margin-left: 0px;margin-right: 5px;">
    @php
    $totalWorkHover = 0;
    $totalWorkMinute = 0;
    $index=1;
    @endphp
    @foreach ($data as $item)
    <div class="row attendanceshow">

        <div class="col-4">
            <span style="margin-right: 12px;">{{ $index }}.</span> {{ $item->date }}
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
            @php
            $index+=1;
            $totalWorkHover+=$totalHover;
            $totalWorkMinute+=$totalMinute;
            if($totalWorkMinute>=60)
            {
            $totalWorkHover+=1;
            $totalWorkMinute-=60;
            }
            @endphp
        </div>
        <div class="col-4" style="display: flex;justify-content: end;padding-right: 34px;">
            <a href="/Attendance-Delete/{{ $item->id }}" style="color:red;text-decoration: none;">
                <span>Remove</span>
            </a>
        </div>

    </div>
    @endforeach

    <div style="margin: 20px 0px 30px 0px;background: white;width: 98%;display: flex;">
        <div>Total Hourse :</div>

        <h4 style="padding-left: 200px;">{{ $totalWorkHover }}:{{ $totalWorkMinute }}</h4>
    </div>
    <div style="margin: 20px 0px 30px 0px;background: white;width: 98%;display: flex;justify-content: space-around;">
        <form action="{{ route('pdf.manage') }}" method="post">
            @csrf
            <input type="text" name="action" value="view" hidden id="">
            <input type="text" name="userid" value="{{ $userid }}" hidden id="">
            <input type="text" name="month" value="{{ $month }}" hidden id="">
            <input type="text" name="hourse" value="{{ $totalWorkHover }}" id="" hidden>
            <input type="text" name="minutes" value="{{ $totalWorkMinute }}" id="" hidden>
            <input type="submit" class="btn btn-primary" value="View Slip">
        </form>
        <form action="{{ route('pdf.manage') }}" method="post">
            @csrf
            <input type="text" name="action" value="download" hidden id="">
            <input type="text" name="month" value="{{ $month }}" hidden id="">
            <input type="text" name="userid" value="{{ $userid }}" hidden id="">
            <input type="text" name="hourse" value="{{ $totalWorkHover }}" id="" hidden>
            <input type="text" name="minutes" value="{{ $totalWorkMinute }}" id="" hidden>
            <input type="submit" class="btn btn-primary" value="Download Slip">
        </form>
    </div>
</div>
@endsection
