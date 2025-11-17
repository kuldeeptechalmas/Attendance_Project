<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechSoft Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        .profilediv {
            height: 45px;
            background-color: #2800ff;
            width: 51px;
            border-radius: 10px;
            margin-right: 20px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 21px;
            position: relative;
        }

        .profiledivinfo {
            position: absolute;
            top: 45px;
            right: -5px;
            display: none;
            border-top: 10px solid white;
        }

        .profilediv:hover .profiledivinfo {
            display: block;
        }

        .profiledivinfo_inner {
            background: white;
            border-radius: 22px;
            box-shadow: 1px 1px 7px black;
            height: 306px;
            width: 288px;
        }

        .floatdivchar {
            height: 80px;
            width: 80px;
            background-color: #2800ff;
            border-radius: 13px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
        }

        body {
            overflow-x: hidden;
        }

    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white" style="height: 85px;">
        <div class="container-fluid">
            @if (Auth::user()->roles=='HR' || Auth::user()->roles=='Employee' )

            <a class="navbar-brand text-primary" href="{{ route('user.Dashboard') }}" style="margin-left: 18px;">
                <img style="height: 42px;" src="{{ asset('images/logo.png') }}" alt="">
                TechSoft</a>
            @else
            <a class="navbar-brand text-primary" href="{{ route('admin.dashbord') }}" style="margin-left: 18px;">
                <img style="height: 42px;" src="{{ asset('images/logo.png') }}" alt="">
                TechSoft</a>
            @endif
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                </ul>
                <form class="d-flex" role="search">
                    <div class="profilediv">
                        {{ Str::upper(value: (substr(Auth::user()->name,0,2))) }}
                        <div class="profiledivinfo">
                            <div class="profiledivinfo_inner">
                                <div style="display: flex;justify-content: center;padding-top: 20px;">
                                    <div class="floatdivchar">
                                        {{ Str::upper(value: (substr(Auth::user()->name,0,2))) }}
                                    </div>
                                </div>
                                <div class="mx-4" style="color: black;font-size: 16px;text-align: center;margin-top: 17px;">
                                    <span>
                                        {{ Auth::user()->name }}
                                    </span>
                                    <br>
                                    <span class="mt-5">
                                        {{ Auth::user()->email }}
                                    </span>
                                    <hr>
                                </div>
                                <div class="text-dark mx-4" style="font-size: 18px;">
                                    <a href="{{ route('admin.profile') }}" style="color: black;text-decoration: none;">
                                        <i class="fa-solid fa-user"></i> Profile
                                    </a>
                                    <hr>
                                </div>
                                <div class="text-dark mx-4" style="font-size: 18px;">
                                    <a href="{{ route('user.logout') }}" style="color: red;text-decoration: none;">
                                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div class="row mt-3">
        <div class="col-3 bg-white" style="height: 435px;">
            <h5 style="margin: 25px;">
                Hi, 👋 <br>
                Welcome To <br>
                {{ Auth::user()->roles }} <br>
            </h5>
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.employee.manage') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Employee
                </a>
            </div>
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.hr.manage') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    HR
                </a>
            </div>
            @if (Auth::user()->roles=='Super Admin')

            <div style="padding:10px 25px;">
                <a href="{{ route('superadmin.show.admin') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Admin
                </a>
            </div>
            @endif
            @if (Auth::user()->roles=='Super Admin')
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.add') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Add Employee,HR,Admin
                </a>
            </div>
            @else
            <div style="padding:10px 25px;">
                <a href="{{ route('admin.add') }}" style="font-size: 18px;color: black;text-decoration: none;">
                    Add Employee,HR
                </a>
            </div>
            @endif
        </div>
        <div class="col-9">
            @if (isset($dashboard))
            <div style="background-color: white;padding: 10px 23px;">
                <div style="font-size: 22px;">
                    Welcome,<br>
                    To TechSoft<br>
                    All Members
                </div>

                <div style="text-align: center;">
                    <h3>
                        TechSoft LLT.
                    </h3>
                </div>
                <table class="table table-striped table-hover">
                    <tr>
                        <td>Index.</td>
                        <td>Name</td>
                        <td>Totals</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Employees</td>
                        <td> {{ $countemployee }}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>HR</td>
                        <td> {{ $counthr }}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Admin</td>
                        <td> {{ $countadmin }}</td>
                    </tr>
                </table>

            </div>
            @else
            @yield('content')

            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
