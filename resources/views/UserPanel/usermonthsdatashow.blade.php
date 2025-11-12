@extends('UserPanel/userindex')

@section('content')
<div class="row" style="margin-left: 0px;margin-right: 5px;">
    @php
    $totalWorkHover = 0;
    $totalWorkMinute = 0;
    $index=1;
    @endphp
    <h3>Attendance of Month : {{ $month }}/2025</h3>
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
        <div style="margin-top: 20px;margin-bottom: 10px;margin-left: 33px;">
            Total Time :
            <span id="changetime">
                {{$totalHover }}:{{ $totalMinute }}
            </span>
            <br>
            @foreach ($item->checkinoutdataget as $check)
            <input type="text" name="" value="{{ $item->id }}" id="" hidden>
            <input style="margin: 14px 12px 10px 12px;" onchange="checkintimesHR(this)" type="time" name="checkintime" value="{{ $check->check_in_time }}" id="checkintime">
            <input type="text" name="id" id="checkid" value="{{ $check->id }}" hidden>
            <input style="margin: 14px 12px 10px 12px;" onchange="checkouttimesHR(this)" type="time" name="checkouttime" value="{{ $check->check_out_time }}" id="checkouttime">
            <input type="text" name="" value="{{ $item->id }}" id="" hidden>
            <a href="/Check-Delete/{{ $check->id }}" style="margin-left: 312px;text-decoration: none;color:red">
                <i class="fa-solid fa-trash"></i>
            </a>
            <br>
            @endforeach
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
<script>
    function checkintimesHR(e) {


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
                $($(e).parent().find("#changetime").html(res['hover'] + ":" + res['minute']));
            }
            , error: function() {

            }
        });
    }

    function checkouttimesHR(e) {

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
                $($(e).parent().find("#changetime").html(res['hover'] + ":" + res['minute']));
            }
            , error: function() {

            }
        });
    }

</script>
@endsection
