@extends('UserPanel.userindex')

@section('content')
<div style="background: white;padding: 20px 262px 10px 240px;height: 435px;">
    <h3>Add Attendance</h3>
    <form action="{{ route('add.attendance.employee') }}" method="post">
        @csrf
        <input type="text" name="userid" value="{{ $userid }}" hidden id="">
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="{{ old('date') }}" class="form-control">
        </div>
        @error("date")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
            <label class="form-label">Check In Time</label>
            <input type="time" name="checkin" value="{{ old('checkin') }}" class="form-control">
        </div>
        @error("checkin")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
            <label class="form-label">Check Out Time</label>
            <input type="time" name="checkout" value="{{ old('checkout') }}" class="form-control">
        </div>
        @error("checkout")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror
        <div class="mb-3">
            <label class="form-label">Break</label>
            <input type='checkbox' value="yes" style="margin-left: 20px;" name="break" value="{{ old('break') }}">
        </div>
        <div style="display: flex;justify-content: space-around;">
            <a href="/Employees">
                <input type="button" class="btn btn-secondary" value="Back">
            </a>
            <input type="submit" class="btn btn-primary" value="Add Attendance">
        </div>
    </form>
</div>
@endsection
