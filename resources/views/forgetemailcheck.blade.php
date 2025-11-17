<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/user/forgotemailpassword.css') }}">
    <title>ForgetEmailCheck</title>

</head>
<body class="bg-light">
    <div class="row">
        <div class="col-6">
            <div style="padding-left: 87px;padding-top: 17px;">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('images/forgetemail.png') }}" alt="">
                </a>
            </div>
        </div>
        <div class="col-6" style="margin-top: 8%;padding-right: 57px;">
            <form class="bg-white loginform" action="{{ route('user.forget.email.check') }}" method="post">
                @csrf
                <div class="logindivlogintext">Check Email</div>
                <div style="margin-bottom: 20px;">
                    <label class="form-label">Email Address</label>
                    <input type="text" value="{{ old('email') }}" name="email" class="form-control">
                </div>
                @error("email")
                <div class="alert alert-danger errordiv" role="alert">
                    {{ $message }}
                </div>
                @else
                <div style="margin-bottom: 36px;">

                </div>
                @enderror


                <div style="text-align: center;">
                    <button type="submit" class="btn btn-primary w-100">Verify Email</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
