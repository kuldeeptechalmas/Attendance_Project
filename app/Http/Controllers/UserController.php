<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SebastianBergmann\Diff\Diff;

class UserController extends Controller
{
    // Dashbord
    public function User_Dashboard(Request $request)
    {
        $User_Attendance_All = Attendance::where("user_id", Auth::user()->id)->get();

        return view("UserPanel.userindex", ['dashboard' => 'yes', 'attendance' => $User_Attendance_All]);
    }

    // Profile User
    public function User_Profile(Request $request)
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
                ],
                "email" => [
                    'required',
                    'email:rfc,dns',
                    'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/',
                    Rule::unique("users", "email")->ignore(Auth::user()->id),
                ],
                "roles" => "required",
                "joinindate" => "required",
                "salary" => "required|numeric|gt:4999",
            ], [
                "name.required" => "Enter Name is Required",
                "name.not_regex" => "Not Only Number is Required",

                "email.required" => "Enter Email is Required",
                "email.email" => "Enter Valid Email is Required.",
                "email.regex" => "Enter Email is gmail.com and yohoo.com Required.",

                "roles.required" => "Enter Roles is Required",
                "joinindate.required" => "Enter Join in Date is Required",

                "salary.required" => "Enter Salary is Required",
                "salary.numeric" => "Enter Only Number is Required",
                "salary.gt" => "Enter Salary is 5000 Up Required",
            ]);

            if ($validators->fails()) {
                return redirect()->back()->withInput()->withErrors($validators);
            }

            $Find_User = User::find(Auth::user()->id);
            $Find_User->name = $request->name;
            $Find_User->phoneno = $request->phoneno;
            $Find_User->roles = $request->roles;
            $Find_User->salary = $request->salary;
            $Find_User->joinindate = $request->joinindate;
            $Find_User->email = $request->email;
            $Find_User->save();

            Auth::login($Find_User);
            return redirect()->back()->with(["update" => "yes"]);
        }
        return view("UserPanel.userprofile");
    }

    // Logout User
    public function User_Logout(Request $request)
    {
        Auth::logout();
        return redirect()->route("login");
    }
}
