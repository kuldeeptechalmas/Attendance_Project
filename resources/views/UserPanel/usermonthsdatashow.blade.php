@extends('UserPanel/userindex')

@section('content')
@toastifyCss

@if($delete=='yes')
{{ toastify()->error('Your Record Remove was successful!') }}
@endif

@session("delete")
{{ toastify()->error('Your Record Remove was successful!') }}
@endsession

@toastifyJs

<div class="row" style="margin-left: 0px;margin-right: 5px;">
    @php
    $totalWorkHover = 0;
    $totalWorkMinute = 0;
    $index=1;
    @endphp
    <div style="display: flex;justify-content: space-around;">

        <h3>Attendance of Month : {{ $month }}/{{ $year }}</h3>
        <div>
            @if (Auth::user()->roles=='HR')

            <a href="{{ route('add.attendance.employee',['userid'=>$userid]) }}">

                <input type="button" class="btn btn-primary" value="Add Attendance">
            </a>
            @endif
        </div>
    </div>
    @if (Auth::user()->roles=='HR')
    <div style="background: white;margin-bottom: 20px;height: 37px;">
        Employee Name : {{ $username }}
    </div>
    <table class="table table-white table-hover">
        <tr>
            <td>Index</td>
            <td>Date</td>
            <td>Check In and Out Time</td>
            <td>Total Hover</td>
            <td>Delete</td>
        </tr>
        @foreach ($data as $item)

        <tr>
            <td>{{ $index }}</td>
            @php
            $totalHover = 0;
            $totalMinute = 0;
            $totalBreakHover = 0;
            $totalBreakMinute = 0;

            @endphp
            @foreach ($item->checkinoutdataget as $check)
            @if ($check->check_out_time!='00:00:00')

            @php

            $time1 = now()::parse($check->check_in_time);
            $time2 = now()::parse($check->check_out_time);
            $diffrence = $time1->diff($time2);
            $totalHover+=$diffrence->h;
            $totalMinute+=$diffrence->i;

            if($totalMinute>=60)
            {
            $totalHover+=1;
            $totalMinute-=60;
            }
            @endphp
            @if ($check->break!=null)


            @php

            $time1 = now()::parse($check->check_in_time);
            $time2 = now()::parse($check->check_out_time);
            $diffrence = $time1->diff($time2);
            $totalBreakHover+=$diffrence->h;
            $totalBreakMinute+=$diffrence->i;

            if($totalBreakMinute>=60)
            {
            $totalBreakHover+=1;
            $totalBreakMinute-=60;
            }
            @endphp
            @endif
            @endif
            @endforeach
            @php
            $index+=1;
            $totalHover-=$totalBreakHover;
            $totalMinute-=$totalBreakMinute;

            $totalWorkHover+=$totalHover;
            $totalWorkMinute+=$totalMinute;
            if($totalWorkMinute>=60)
            {
            $totalWorkHover+=1;
            $totalWorkMinute-=60;
            }
            @endphp
            <td>{{ $item->date }}</td>
            <td id="maintd" class="d-flex w-100 flex-column">
                @if ($item->checkinoutdataget->isNotEmpty())

                @foreach ($item->checkinoutdataget as $check)
                <div class="d-flex align-items-center">
                    <input type="text" name="" value="{{ $item->id }}" id="" hidden>
                    <input style="margin: 14px 12px 10px 12px;" onchange="checkintimesHR(this)" type="time" name="checkintime" value="{{ $check->check_in_time }}" id="checkintime">
                    <input type="text" name="id" id="checkid" value="{{ $check->id }}" hidden>
                    <input style="margin: 14px 12px 10px 12px;" onchange="checkouttimesHR(this)" type="time" name="checkouttime" value="{{ $check->check_out_time }}" id="checkouttime">
                    <input type="text" name="" value="{{ $item->id }}" id="" hidden>
                    @if ($check->break!=null)
                    BT
                    @endif
                    <form action="{{ route('check.data.delete') }}" method="post">
                        @csrf
                        <input type="text" name="checkid" value="{{ $check->id }}" hidden id="">
                        <button type="submit"><i class="fa-solid fa-trash"></i></button>
                    </form>
                    {{-- <a href="/Check-Delete/{{ $check->id }}" style="margin-top: 17px;margin-left: 38px;text-decoration: none;color:red">

                    </a> --}}
                </div>
                @endforeach
                @else
                Add Data
                @endif
            </td>
            <td id="changetime">
                {{$totalHover }} :
                @if (strlen($totalMinute)==1)
                0{{ $totalMinute }}
                @else
                {{ $totalMinute }}
                @endif
            </td>
            <td>
                <a href="/Attendance-Delete/{{ $item->id }}" style="color:red;text-decoration: none;">
                    <span>Remove</span>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
    @endif

    @if (Auth::user()->roles=='Employee')
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
            {{$totalHover }} :
            @if (strlen($totalMinute)==1)
            0{{ $totalMinute }}
            @else
            {{ $totalMinute }}
            @endif
        </div>
        <div class="col-4" style="display: flex;justify-content: end;padding-right: 34px;">
        </div>
    </div>
    @endforeach
    @endif

    <div style="margin: 20px 0px 30px 0px;background: white;width: 98%;display: flex;">
        <div>Total Hourse :</div>

        <h4 style="padding-left: 200px;">{{ $totalWorkHover }}:{{ $totalWorkMinute }}</h4>
    </div>
    <div style="margin: 20px 0px 30px 0px;background: white;width: 98%;display: flex;justify-content: space-around;">
        <form action="{{ route('pdf.manage') }}" target="_blank" method="post">
            @csrf
            <input type="text" name="action" value="view" hidden id="">
            <input type="text" name="userid" value="{{ $userid }}" hidden id="">
            <input type="text" name="month" value="{{ $month }}" hidden id="">
            <input type="text" name="year" value="{{ $year }}" hidden id="">
            <input type="text" name="day" value="{{ count($data) }}" hidden id="">
            <input type="text" name="hourse" value="{{ $totalWorkHover }}" id="" hidden>
            <input type="text" name="minutes" value="{{ $totalWorkMinute }}" id="" hidden>
            <input type="submit" class="btn btn-primary" value="View Slip">
        </form>
        <form action="{{ route('pdf.manage') }}" method="post">
            @csrf
            <input type="text" name="action" value="download" hidden id="">
            <input type="text" name="month" value="{{ $month }}" hidden id="">
            <input type="text" name="userid" value="{{ $userid }}" hidden id="">
            <input type="text" name="day" value="{{ count($data) }}" hidden id="">
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
                // $($(e).parent().find("#changetime").html(res['hover'] + ":" + res['minute']));
                $(e).parent().parent().next().html(res['hover'] + ":" + res['minute']);
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
                // $($(e).parent().find("#changetime").html(res['hover'] + ":" + res['minute']));
                $(e).parent().parent().next().html(res['hover'] + ":" + res['minute']);
            }
            , error: function() {

            }
        });
    }

</script>
@endsection
