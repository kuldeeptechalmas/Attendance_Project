@extends('UserPanel/userindex')

@section('content')
@if ($months->isNotEmpty())
Select Month To Get Data:
<div class="row" style="margin: 35px;">
    @foreach ($months as $item)

    <form action="{{ route('month.attendance.show') }}" method="post">
        @csrf
        <input type="text" name="userid" hidden value="{{ $userid }}" id="">
        <input type="text" name="month" hidden value="{{ $item->month }}" id="">
        <input type="submit" class="btn btn-white card" style="align-items: center;margin: 10px;height: 50px;display: flex;justify-content: center;width: 282px;" value="{{ $item->month }}/2025">
    </form>
    @endforeach
</div>
@else
<div style="display: flex;justify-content: center;font-size: 22px;margin-top: 190px;">
    <div style="background: white;width: 200px;display: flex;justify-content: center;">
        Not Found Data
    </div>
</div>
@endif

@endsection
