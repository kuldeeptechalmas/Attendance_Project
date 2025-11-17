@extends('UserPanel/userindex')

@section('content')

<style>
    .formregistaration {
        border-radius: 30px;
        padding: 20px 198px 0px 198px;
    }

    .passwordicon {
        top: 63%;
        right: 19px;
    }

    .errordiv {
        height: 45px;
        display: flex;
        align-items: center;
    }

</style>
@toastifyCss
@session('save')
{{ toastify()->success('Your Record Was Save Successful!') }}
@endsession
@toastifyJs

<div class="bg-white">
    <h1 style="text-align: center;padding-top: 18px;">
        @if (Auth::user()->roles=='Super Admin')
        Add Employee/Hr/Admin
        @else
        Add Employee/Hr
        @endif
    </h1>
    <form class="formregistaration" method="post" action="{{ route('admin.add') }}">
        @csrf
        <input type="text" name="action" value="modify" hidden>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
        </div>
        @error("name")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Phone No.</label>
            <input type="text" name="phoneno" value="{{ old('phoneno') }}" class="form-control">
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

                <option value="Employee" {{ old('roles')=='Employee'?'selected':'' }}>Employee</option>
                <option value="HR" {{ old('roles')=='HR'?'selected':'' }}>HR</option>

                @if (Auth::user()->roles=='Super Admin')
                <option value="Admin" {{ old('roles')=='Admin'?'selected':'' }}>Admin</option>
                @endif
            </select>
        </div>
        @error("roles")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Salary</label>
            <input type="text" name="salary" value="{{ old('salary') }}" class="form-control">
        </div>
        @error("salary")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Join in Date</label>
            <input type="date" name="joinindate" class="form-control" value="{{ old('joinindate') }}" style="height: 40px;">
        </div>
        @error("joinindate")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="text" name="email" value="{{ old('email') }}" class="form-control">
        </div>
        @error("email")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3 position-relative">
            <label class="form-label">Password</label>
            <input type="password" name="password" value="{{ old('password') }}" id="passwordLogin" class="form-control">
            <i class="fa-solid fa-eye position-absolute passwordicon" onclick="hiddpasswordlogin()" id="showpassword" hidden></i>
            <i class="fa-solid fa-eye-slash position-absolute passwordicon" onclick="showpasswordlogin()" id="hiddpassword"></i>
        </div>
        @error("password")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3 position-relative">
            <label class="form-label">Conform Password</label>
            <input type="password" name="conformpassword" value="{{ old('conformpassword') }}" id="conformpasswordLogin" class="form-control">
            <i class="fa-solid fa-eye position-absolute passwordicon" onclick="hiddconformpasswordlogin()" id="showconformpassword" hidden></i>
            <i class="fa-solid fa-eye-slash position-absolute passwordicon" onclick="showconformpasswordlogin()" id="hiddconformpassword"></i>
        </div>
        @error("conformpassword")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="text-center py-5" style="display: flex;justify-content: space-between;">
            <a href="{{ route('admin.dashbord') }}">
                <button type="button" class="btn btn-secondary">Back</button>
            </a>
            <button type="submit" class="btn btn-primary">Add User</button>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    // password function
    function showpasswordlogin() {
        $("#showpassword").removeAttr("hidden");
        $("#hiddpassword").attr("hidden", true);
        document.getElementById("passwordLogin").type = "text";
    }

    function hiddpasswordlogin() {
        $("#showpassword").attr("hidden", true);
        $("#hiddpassword").removeAttr("hidden");
        document.getElementById("passwordLogin").type = "password";
    }
    // Conform Password
    function showconformpasswordlogin() {
        $("#showconformpassword").removeAttr("hidden");
        $("#hiddconformpassword").attr("hidden", true);
        document.getElementById("conformpasswordLogin").type = "text";
    }

    function hiddconformpasswordlogin() {
        $("#showconformpassword").attr("hidden", true);
        $("#hiddconformpassword").removeAttr("hidden");
        document.getElementById("conformpasswordLogin").type = "password";
    }

</script>
@endsection
