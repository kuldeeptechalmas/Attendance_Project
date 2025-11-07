<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                    return redirect()->route("user.Dashboard");
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

            return redirect()->route('login');
        }
        return view("registration");
    }
}
