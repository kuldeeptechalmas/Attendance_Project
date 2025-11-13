<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/user/registration.css') }}">
    <title>Registration</title>

</head>
<body class="bg-light maindiv">
    <div class="bg-white card rounded-5">
        <div class="row">
            <div class="col-6">
                <h5 class="text-center mt-4" style="font-size: 24px;">Registration</h5>
                <form class="formregistaration" method="post" action="{{ route('registration') }}">
                    @csrf
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
                        </select>
                        {{-- <input type="text" value="{{ old('roles') }}" class="form-control"> --}}
                    </div>
                    @error("roles")
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

                    <div class="text-center mt-5">
                        <button type="submit" class="btn btn-primary w-100">Registration</button>
                    </div>
                    <div class="my-4 text-center">
                        You have already Account ? <br>
                        <a href="{{ route('login') }}">
                            Login
                        </a>
                    </div>
                </form>
            </div>
            <div class="col-6">
                <div style="margin-top: 15%;">
                    <img src="{{ asset('images/registration-image.png') }}" style="height: 100%;width: 100%;">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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

</body>
</html>
