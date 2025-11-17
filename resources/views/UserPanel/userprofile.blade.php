@extends('UserPanel.userindex')
@section('content')

@toastifyCss
@session('update')
{{ toastify()->success('Your action was successful!') }}
@endsession
@toastifyJs

<div class="bg-white">
    <h1 style="text-align: center;padding-top: 18px;">Profile</h1>
    <form class="formregistaration" method="post" action="{{ route('user.profile') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name',Auth::user()->name) }}" class="form-control">
        </div>
        @error("name")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Phone No.</label>
            <input type="text" name="phoneno" value="{{ old('phoneno',Auth::user()->phoneno) }}" class="form-control">
        </div>
        @error("phoneno")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Roles</label>
            <select class="form-select" style="height: 40px;" name="roles" aria-label="Default select example">
                <option value="">Select</option>

                @if(Auth::user()->email=='superadmin12@gmail.com')
                <option value="Super Admin" {{ old('roles',Auth::user()->roles)=='Super Admin'?'selected':'' }}>Super Admin</option>
                <option value="Admin" {{ old('roles',Auth::user()->roles)=='Admin'?'selected':'' }}>Admin</option>
                <option value="HR" {{ old('roles',Auth::user()->roles)=='HR'?'selected':'' }}>HR</option>
                <option value="Employee" {{ old('roles',Auth::user()->roles)=='Employee'?'selected':'' }}>Employee</option>
                @elseif (Auth::user()->roles=='HR')
                <option value="HR" {{ old('roles',Auth::user()->roles)=='HR'?'selected':'' }}>HR</option>
                @elseif (Auth::user()->roles=='Admin')
                <option value="Admin" {{ old('roles',Auth::user()->roles)=='Admin'?'selected':'' }}>Admin</option>
                @elseif (Auth::user()->roles=='Employee')
                <option value="Employee" {{ old('roles',Auth::user()->roles)=='Employee'?'selected':'' }}>Employee</option>
                @endif

            </select>
        </div>
        @error("roles")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Join in Date</label>
            <input type="date" name="joinindate" class="form-control" value="{{ old('joinindate',Auth::user()->joinindate) }}" style="height: 40px;">
        </div>
        @error("joinindate")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror
        @if (Auth::user()->email=='superadmin12@gmail.com')

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="text" name="email" readonly value="{{ old('email',Auth::user()->email) }}" class="form-control">
        </div>
        @else
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="text" name="email" value="{{ old('email',Auth::user()->email) }}" class="form-control">
        </div>
        @endif

        @error("email")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="text-center py-5">
            <button type="submit" class="btn btn-primary w-100">Save Change</button>
        </div>
    </form>
</div>
@endsection
