<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Login</title>
    <style>
        .loginform {
            border-radius: 23px;
            padding: 0px 51px 30px 51px;
        }

        .logindivlogintext {
            font-size: 40px;
            padding-top: 8%;
            display: flex;
            justify-content: center;
        }

        .passwordicon {
            top: 63%;
            right: 19px;
        }

        .loginimage {
            height: 85%;
            width: 100%;
            object-fit: contain;
        }

        .errordiv {
            height: 37px;
            display: flex;
            align-items: center;
        }

    </style>
</head>
<body class="bg-light">
    <div class="row" style="margin: 11px 54px 0px 87px;">
        <div class="col-6">
            <img class="loginimage" src="{{ asset("images/loginimage.png") }}" alt="">
        </div>
        <div class="col-6" style="margin-top: 6%;">
            <form class="bg-white loginform" action="{{ route('login') }}" method="post">
                @csrf
                <div class="logindivlogintext">Login</div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="text" value="{{ old('email') }}" name="email" class="form-control">
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

                <div class="mb-5">
                    Don’t have an account? <br>
                    <a href="{{ route('registration') }}">
                        Registration
                    </a>
                </div>
                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
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

    </script>
</body>
</html>
