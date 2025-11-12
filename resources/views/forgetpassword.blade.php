<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/user/forgotpassword.css') }}">
    <title>ForgetPassword</title>

</head>
<body class="bg-light">
    <div class="row">
        <div class="col-6" style="margin-top: 8%;padding-right: 57px;padding-left: 87px;">
            <form class="bg-white loginform" action="{{ route('user.forget.password') }}" method="post">
                @csrf
                <div class="logindivlogintext">Forgot Password</div>

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

                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary w-100">Forgot Passwod</button>
                </div>
            </form>
        </div>
        <div class="col-6">
            <div style="padding-top: 17px;">
                <img src="{{ asset('images/forgetpassword.png') }}" alt="">
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
