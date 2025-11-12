<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    // Admin Dashborad
    public function Admin_Dashborad()
    {
        $Count_Employee = User::where('roles', 'Employee')->get();
        $Count_Hr = User::where('roles', 'HR')->get();
        $Count_Admin = User::where('roles', 'Admin')->get();

        return view('AdminPanel.adminindex', [
            'dashboard' => 'yes',
            'countemployee' => $Count_Employee->count(),
            'counthr' => $Count_Hr->count(),
            'countadmin' => $Count_Admin->count(),
        ]);
    }

    // Admin Profile
    public function Admin_Profile(Request $request)
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
                    Rule::unique("users", 'phoneno')->ignore(Auth::user()->id),
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

                "phoneno.required" => "Enter Phone No is Required",
                "phoneno.numeric" => "Enter Only Number is Required",
                "phoneno.digits" => "Enter 10 Digit Phone No is Required",
                "phoneno.unique" => "Enter Phone No has Already Been Taken.",

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
        return view('AdminPanel.adminprofile');
    }

    // Admin Manage Employee
    public function Admin_Employee_Manage(Request $request)
    {
        if ($request->action == 'Remove') {
            $find_user = User::find($request->id);
            if (isset($find_user)) {
                $find_user->delete();
                return redirect()->back()->with(["delete" => "yes"]);
            }
        }
        $user_Employee = User::where('roles', 'Employee')->paginate(10);
        if (isset($user_Employee)) {
            return view('AdminPanel.employeeshow', ['data' => $user_Employee]);
        } else {
            return redirect()->back()->with("error", "Not Found Data");
        }
    }

    // Admin find Employee
    public function Admin_Find_Employee($userid, Request $request)
    {
        $Get_user = User::find($userid);
        if ($Get_user) {
            return view('AdminPanel.usermodifydetail', ['employee' => $Get_user]);
        } else {
            return redirect()->back()->with('error', 'not found record');
        }
    }

    // Admin Modify detail
    public function Admin_Modify_Employee(Request $request)
    {
        $validators = Validator::make($request->all(), [
            "name" => [
                'required',
                'not_regex:/^\d+$/'
            ],
            "phoneno" => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique("users", 'phoneno')->ignore($request->id),
            ],
            "email" => [
                'required',
                'email:rfc,dns',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/',
                Rule::unique("users", "email")->ignore($request->id),
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

            "phoneno.required" => "Enter Phone No is Required",
            "phoneno.numeric" => "Enter Only Number is Required",
            "phoneno.digits" => "Enter 10 Digit Phone No is Required",
            "phoneno.unique" => "Enter Phone No has Already Been Taken.",

            "salary.required" => "Enter Salary is Required",
            "salary.numeric" => "Enter Only Number is Required",
            "salary.gt" => "Enter Salary is 5000 Up Required",
        ]);

        if ($validators->fails()) {
            return redirect()->back()->withInput()->withErrors($validators);
        }

        $Find_User = User::find($request->id);
        $Find_User->name = $request->name;
        $Find_User->phoneno = $request->phoneno;
        $Find_User->roles = $request->roles;
        $Find_User->salary = $request->salary;
        $Find_User->joinindate = $request->joinindate;
        $Find_User->email = $request->email;
        $Find_User->save();

        return redirect()->back()->with(["update" => "yes"]);
    }

    // Admin Manage Hr
    public function Admin_Hr_Manage(Request $request)
    {
        $hr_Employee = User::where('roles', 'HR')->paginate(10);
        if (isset($hr_Employee)) {
            return view('AdminPanel.hrshow', ['data' => $hr_Employee]);
        } else {
            return redirect()->back()->with("error", "Not Found Data");
        }
    }

    // Admin find HR
    public function Admin_Find_Hr($hrid, Request $request)
    {
        $Get_hr = User::find($hrid);
        if ($Get_hr) {
            return view('AdminPanel.hrmodifydetail', ['hr' => $Get_hr]);
        } else {
            return redirect()->back()->with('error', 'not found record');
        }
    }

    // Admin Modify Hr
    public function Admin_Modify_Hr(Request $request)
    {
        $validators = Validator::make($request->all(), [
            "name" => [
                'required',
                'not_regex:/^\d+$/'
            ],
            "phoneno" => [
                'required',
                'numeric',
                'digits:10',
                Rule::unique("users", 'phoneno')->ignore($request->id),
            ],
            "email" => [
                'required',
                'email:rfc,dns',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail|yahoo)\.com$/',
                Rule::unique("users", "email")->ignore($request->id),
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

            "phoneno.required" => "Enter Phone No is Required",
            "phoneno.numeric" => "Enter Only Number is Required",
            "phoneno.digits" => "Enter 10 Digit Phone No is Required",
            "phoneno.unique" => "Enter Phone No has Already Been Taken.",

            "salary.required" => "Enter Salary is Required",
            "salary.numeric" => "Enter Only Number is Required",
            "salary.gt" => "Enter Salary is 5000 Up Required",
        ]);

        if ($validators->fails()) {
            return redirect()->back()->withInput()->withErrors($validators);
        }

        $Find_User = User::find($request->id);
        $Find_User->name = $request->name;
        $Find_User->phoneno = $request->phoneno;
        $Find_User->roles = $request->roles;
        $Find_User->salary = $request->salary;
        $Find_User->joinindate = $request->joinindate;
        $Find_User->email = $request->email;
        $Find_User->save();

        return redirect()->back()->with(["update" => "yes"]);
    }

    // Admin Add Employee and Hr
    public function Admin_Add_Employee_HR(Request $request)
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
                    'unique:users,phoneno',
                    Password::min(8)
                        ->mixedCase()
                        ->symbols()
                        ->numbers(),
                ],
                "roles" => "required",
                "joinindate" => "required",
                "conformpassword" => "required|same:password",
                "salary" => "required|numeric|gt:4999",
            ], [
                "name.required" => "Enter Name is Required",
                "name.not_regex" => "Not Only Number is Required",

                "conformpassword.required" => "Enter Conform Password is Required",
                "conformpassword.same" => "Enter Conform Password Not Match Password.",

                "phoneno.required" => "Enter Phone No is Required",
                "phoneno.numeric" => "Enter Only Number is Required",
                "phoneno.digits" => "Enter 10 Digit Phone No is Required",
                "phoneno.unique" => "Enter Phone No has Already Been Taken.",

                "email.required" => "Enter Email is Required",
                "email.unique" => "Enter Email has Already Been Taken.",
                "email.email" => "Enter Valid Email is Required.",
                "email.regex" => "Enter Email is gmail.com and yohoo.com Required.",

                "password.required" => "Enter Password is Required",
                "roles.required" => "Enter Roles is Required",
                "joinindate.required" => "Enter Join in Date is Required",

                "salary.required" => "Enter Salary is Required",
                "salary.numeric" => "Enter Only Number is Required",
                "salary.gt" => "Enter Salary is 5000 Up Required",
            ]);

            if ($validators->fails()) {
                return redirect()->back()->withInput()->withErrors($validators);
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phoneno = $request->phoneno;
            $user->roles = $request->roles;
            $user->salary = $request->salary;
            $user->joinindate = $request->joinindate;
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back()->with(['save' => "yes"]);
        }
        return view('AdminPanel.addemployeeandhr');
    }

    // Super Admin Manage Admin
    public function SuperAdmin_Show_Admin(Request $request)
    {
        $admin_employee = User::where('roles', 'Admin')->paginate(10);
        if (isset($admin_employee)) {
            return view('AdminPanel.adminshow', ['data' => $admin_employee]);
        } else {
            return redirect()->back()->with("error", "Not Found Data");
        }
    }

    public function SuperAdmin_Find_Admin($adminid, Request $request)
    {
        $get_admin = User::find($adminid);
        if ($get_admin) {
            return view('AdminPanel.adminmodifydetail', ['admin' => $get_admin]);
        } else {
            return redirect()->back()->with('error', 'not found record');
        }
    }
}
