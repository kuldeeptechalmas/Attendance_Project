@extends('UserPanel.userindex')

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
    <h1 style="text-align: center;padding-top: 18px;">Modify Employees Detail</h1>
    <form class="formregistaration" method="post" action="{{ route('employee.data.modify') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name',$employee->name) }}" class="form-control">
        </div>
        @error("name")
        <div class="alert alert-danger errordiv" role="alert">
            {{ $message }}
        </div>
        @enderror

        <input type="text" name="id" value="{{ $employee->id }}" hidden id="">

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
            <input type="text" name="email" disabled value="{{ old('email',$employee->email) }}" class="form-control">
        </div>
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
