<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SebastianBergmann\Diff\Diff;

class UserController extends Controller
{
    // Dashbord
    public function User_Dashboard(Request $request)
    {
        $User_Attendance_All = Attendance::with('checkinoutdataget')
            ->where("date", now()->toDateString())
            ->where("user_id", Auth::user()->id)
            ->get();
        if (isset($User_Attendance_All)) {

            return view("UserPanel.userindex", ['dashboard' => 'yes', 'attendance' => $User_Attendance_All]);
        } else {
            return redirect()->back()->with(['error' => 'Not Found Data']);
        }
    }

    // Teams Show
    public function Teams(Request $request)
    {
        try {
            $Teams = User::all();
            return view("UserPanel.teams", ['data' => $Teams]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    // HR Get Employees List
    public function HR_get_Employee_Data(Request $request)
    {
        $Get_all_Employee = User::where('roles', 'Employee')->paginate(10);
        if (isset($Get_all_Employee)) {
            return view("UserPanel.HR.hrgetemployee", ['employeedata' => $Get_all_Employee]);
        } else {
            return redirect()->back()->with('error', 'not found record');
        }
    }

    // Hr Get Employee Data By Id
    public function HR_Modify_Employee_Details($id, Request $request)
    {

        $Find_User_Employee = User::find($id);
        if (isset($Find_User_Employee)) {
            return view("UserPanel.HR.employeemodify", ['employee' => $Find_User_Employee]);
        } else {
            return redirect()->back()->with('error', 'not found record');
        }
    }

    // Hr Get Employee Data Modify
    public function Employee_Data_Modify(Request $request)
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
            "roles" => "required",
            "joinindate" => "required",
            "salary" => "required|numeric|gt:4999",
        ], [
            "name.required" => "Enter Name is Required",
            "name.not_regex" => "Not Only Number is Required",

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
        $Find_User->exitdate = isset($request->exitdate) ? $request->exitdate : null;
        $Find_User->save();

        return redirect()->back()->with(["update" => "yes"]);
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
            ]);

            if ($validators->fails()) {
                return redirect()->back()->withInput()->withErrors($validators);
            }

            $Find_User = User::find(Auth::user()->id);
            $Find_User->name = $request->name;
            $Find_User->phoneno = $request->phoneno;
            $Find_User->roles = $request->roles;
            $Find_User->joinindate = $request->joinindate;
            $Find_User->email = $request->email;
            $Find_User->save();

            Auth::login($Find_User);
            return redirect()->back()->with(["update" => "yes"]);
        }
        return view("UserPanel.userprofile");
    }

    // Month wise Data Find
    public function Monthly_Data_For_Employee_Find($empid, Request $request)
    {
        // Hr show Record
        $userid = Auth::user()->id;
        if (isset($empid)) {
            $userid = $empid;
        }

        $Get_Months = DB::table("attendance")
            ->select(DB::raw("MONTH(date) as month,YEAR(date) as year"))
            ->distinct()
            ->where("user_id", $userid)
            ->whereNull('deleted_at')
            ->get();

        Session::put('userid', $userid);

        return view('UserPanel.usermonthattandance', ['months' => $Get_Months, 'userid' => $userid]);
    }

    // Month Wise Data Show
    public function Monthly_Data_For_Employee_Show($month, $year, Request $request)
    {
        // dd()
        // Hr show Record 
        $userid = Auth::user()->id;
        if (Session::get('userid')) {
            $userid = Session::get('userid');
        }
        // $month = Session::get('month');

        $Month_Wise_User_Data = Attendance::with('checkinoutdataget')
            ->where("date", "like", $year . "-" . $month . "-%")
            ->where("user_id", $userid)
            ->get();

        $find_user = User::find($userid);

        if (isset($Month_Wise_User_Data)) {
            return view("UserPanel.usermonthsdatashow", [
                'data' => $Month_Wise_User_Data,
                "month" => $month,
                "year" => $year,
                "userid" => $userid,
                "username" => $find_user->name,
            ]);
        } else {
            dd("Monshs Data Not Found");
        }
    }
}
