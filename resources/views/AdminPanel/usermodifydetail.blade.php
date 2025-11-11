@extends('AdminPanel.adminindex')

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
@session('update')
{{ toastify()->success('Your action was successful!') }}
@endsession
@toastifyJs

<div class="bg-white">
    <h1 style="text-align: center;padding-top: 18px;">Edit Employee</h1>
    <form class="formregistaration" method="post" action="{{ route('admin.modify.employee') }}">
        @csrf
        <input type="text" name="action" value="modify" hidden>
        <input type="text" name="id" value="{{ $employee->id }}" hidden>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name',$employee->name) }}" class="form-control">
        </div>
        @error("name")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Phone No.</label>
            <input type="text" name="phoneno" value="{{ old('phoneno',$employee->phoneno) }}" class="form-control">
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

                <option value="HR" {{ old('roles',$employee->roles)=='HR'?'selected':'' }}>HR</option>
                <option value="Employee" {{ old('roles',$employee->roles)=='Employee'?'selected':'' }}>Employee</option>

            </select>
        </div>
        @error("roles")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Salary</label>
            <input type="text" name="salary" value="{{ old('salary',$employee->salary) }}" class="form-control">
        </div>
        @error("salary")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Join in Date</label>
            <input type="date" name="joinindate" class="form-control" value="{{ old('joinindate',$employee->joinindate) }}" style="height: 40px;">
        </div>
        @error("joinindate")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="text" name="email" value="{{ old('email',$employee->email) }}" class="form-control">
        </div>
        @error("email")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="text-center py-5" style="display: flex;justify-content: space-between;">
            <a href="{{ route('admin.employee.manage') }}">
                <button type="button" class="btn btn-secondary">Back</button>
            </a>
            <button type="submit" class="btn btn-primary">Save Change</button>
        </div>
    </form>
</div>
@endsection
