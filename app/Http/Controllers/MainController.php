<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class MainController extends Controller
{
    // Login User
    public function Login_User(Request $request)
    {
        if ($request->isMethod("post")) {

            $validators = Validator::make($request->all(), [
                "email" => [
                    'required',
                    'email:rfc,dns',
                    'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/'
                ],
                "password" => "required"
            ], [
                "email.required" => "Enter Email is Required",
                "email.email" => "Enter Valid Email is Required.",
                "email.regex" => "Enter Email is gmail.com and yohoo.com Required.",

                "password.required" => "Enter Password is Required.",
            ]);

            if ($validators->fails()) {
                return redirect()->back()->withInput()->withErrors($validators);
            }

            $Find_User = User::where('email', "=", $request->email)->first();

            if (isset($Find_User)) {
                if (Auth::attempt($request->only("email", "password"))) {
                    Auth::login($Find_User);

                    if ($Find_User->roles == 'Admin' || $Find_User->roles == 'Super Admin') {
                        return redirect()->route('admin.dashbord');
                    } else {
                        return redirect()->route("user.Dashboard");
                    }
                } else {
                    return redirect()->back()->withInput()->withErrors(["password" => "Enter Currect Password."]);
                }
            } else {
                return redirect()->back()->withInput()->withErrors(["email" => "Enter Email not Exist !"]);
            }
        }
        return view("login");
    }

    // Registration User
    public function Registration_User(Request $request)
    {
        if ($request->isMethod("post")) {
            $validators = Validator::make($request->all(), [
                "name" => [
                    'required',
                    'not_regex:/^\d+$/'
                ],
                "phoneno" => [
                    'required',
                    'numeric',
                    'digits:10',
                    'unique:users,phoneno',
                ],
                "email" => [
                    'required',
                    'unique:users,email',
                    'email:rfc,dns',
                    'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/'
                ],
                "password" => [
                    "required",
                    Password::min(8)
                        ->mixedCase()
                        ->symbols()
                        ->numbers(),
                ],
                "roles" => "required",
                "joinindate" => "required",
                "conformpassword" => "required|same:password",
            ], [
                "name.required" => "Enter Name is Required",
                "name.not_regex" => "Not Only Number is Required",

                "phoneno.required" => "Enter Phone No is Required",
                "phoneno.numeric" => "Enter Only Number is Required",
                "phoneno.digits" => "Enter 10 Digit Phone No is Required",
                "phoneno.unique" => "Enter Phone No has Already Been Taken.",

                "email.required" => "Enter Email is Required",
                "email.unique" => "Enter Email has Already Been Taken.",
                "email.email" => "Enter Valid Email is Required.",
                "email.regex" => "Enter Email is gmail.com and yohoo.com Required.",

                "password.required" => "Enter Password is Required",
                "password.min" => "Greter then 8 Charecter is Required",
                "password.mixed" => "At Least One Upper and Lower Letter",
                "password.symbols" => "Enter Symbols in Password is Required",
                "password.numbers" => "Enter One Number is Required",

                "conformpassword.required" => "Enter Conform Password is Required",
                "conformpassword.same" => "Conform Password Not Match Password.",

                "roles.required" => "Enter Roles is Required",
                "joinindate.required" => "Enter Join in Date is Required",
            ]);

            if ($validators->fails()) {
                return redirect()->back()->withInput()->withErrors($validators);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phoneno = $request->phoneno;
            $user->roles = $request->roles;
            $user->salary = 0;
            $user->joinindate = $request->joinindate;
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login');
        }
        return view("registration");
    }

    // Logout User
    public function User_Logout(Request $request)
    {
        Auth::logout();
        Session::forget("checkin");
        return redirect()->route("login");
    }

    // PDF Employees
    public function PDF_For_Employee(Request $request)
    {
        $mainSalary = Auth::user()->salary;
        $mainName = Auth::user()->name;
        $mainPhone = Auth::user()->phoneno;

        // HR user
        if (isset($request->userid)) {
            $find_Employee = User::find($request->userid);
            $mainSalary = $find_Employee->salary;
            $mainName = $find_Employee->name;
            $mainPhone = $find_Employee->phoneno;

            $currentStart = now()::createFromDate($request->year, $request->month, '1');
            $currentEnd = $currentStart->copy()->endOfMonth();
            $usermonthjoinin = now()->createFromDate($find_Employee->joinindate)->month;
            $usermonthexit = now()->createFromDate($find_Employee->exitdate)->month;
            $currentmonth = $currentStart->month;
            if ($usermonthjoinin == $currentmonth) {
                $currentStart = now()->createFromDate($find_Employee->joinindate);
            }
            if ($usermonthexit == $currentmonth) {
                $currentEnd = now()->createFromDate($find_Employee->exitdate);
            }
        } else {

            $currentStart = now()::createFromDate($request->year, $request->month, '1');

            if ($request->month == now()->month) {

                $currentEnd = now();
            } else {
                $currentEnd = $currentStart->copy()->endOfMonth();
            }
        }

        $totalDay = $currentStart->daysInMonth;
        $current = $currentStart->copy();

        while ($current->lte($currentEnd)) {
            if ($current->isSunday() || $current->isSaturday()) {
                $weeksInLeave[] = $current->toString();
            }
            $current->addDay();
        }
        // dd($weeksInLeave);

        $workingDay = $totalDay;
        $workingHours = $workingDay * 8;
        $salary = 0;
        $leaveHours = count($weeksInLeave) * 8;
        if ($workingHours <= ($request->hourse + $leaveHours)) {
            $salary = $mainSalary;
        } else {
            $PerHourse = $mainSalary / $workingHours;
            $diffHours = $workingHours - ($request->hourse + $leaveHours);
            $salary = $mainSalary - ($diffHours * $PerHourse);
        }

        $data = [
            "startdate" => $currentStart->toDateString(),
            "enddate" => $currentEnd->toDateString(),
            "totalday" => $totalDay,
            "leavesday" => count($weeksInLeave),
            "hourse" => $request->hourse,
            "minutes" => $request->minutes,
            "workingday" => round($request->hourse / 8),
            "salary" => $salary,
            "name" => $mainName,
            "phone" => $mainPhone,
            "mainsalary" => $mainSalary,
        ];

        if ($request->action == 'view') {
            $pdf = Pdf::loadView("UserPanel.PDF.pdfshow", ['data' => $data]);
            return $pdf->stream('EmployeeSlips.pdf');
        } else {
            $pdf = Pdf::loadView("UserPanel.PDF.pdfshow", ['data' => $data]);
            return $pdf->download('EmployeeSlips.pdf');
        }
    }

    // Forget Email Check
    public function User_Forgot_Email_Check(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'email' => [
                    'required',
                    'email:rfc,dnc',
                    'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/'
                ],
            ], [
                "email.required" => "Enter Email is Required",
                "email.email" => "Enter Valid Email is Required.",
                "email.regex" => "Enter Email is gmail.com and yohoo.com Required.",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $Find_user = User::where('email', $request->email)->first();
            if (isset($Find_user)) {
                Session::put('forgotemail', $Find_user->email);
                return redirect()->route('user.forget.password');
            } else {
                return redirect()->back()->withErrors(['email' => 'User Not Exist !']);
            }
        }
        return view('forgetemailcheck');
    }

    // Forget Password
    public function User_Forgot_Password(Request $request)
    {
        if ($request->isMethod("post")) {
            $validator = Validator::make($request->all(), [
                'password' => [
                    'required',
                    Password::min(8)
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],
                'conformpassword' => [
                    'required',
                    'same:password'
                ],
            ], [
                "password.required" => "Enter Password is Required",
                "password.min" => "Greter then 8 Charecter is Required",
                "password.mixed" => "At Least One Upper and Lower Letter",
                "password.symbols" => "Enter Symbols in Password is Required",
                "password.numbers" => "Enter One Number is Required",

                "conformpassword.required" => "Enter Conform Password is Required",
                "conformpassword.same" => "Conform Password Not Match Password.",
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $find_user = User::where("email", Session::get('forgotemail'))->first();
            if (isset($find_user)) {
                $find_user->password = Hash::make($request->password);
                $find_user->save();
                return redirect()->route('login');
            } else {
                return redirect()->back()->withErrors('error', 'not found record');
            }
        }
        return view('forgetpassword');
    }
}
