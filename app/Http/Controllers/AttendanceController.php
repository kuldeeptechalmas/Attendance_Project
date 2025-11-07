<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    // Check In
    public function Attendance_Check_IN(Request $request)
    {
        $Now_Date = now()->toDateString();

        $Exist_Attendance = Attendance::where("date", $Now_Date)->where("user_id", Auth::user()->id)->first();
        if (isset($Exist_Attendance)) {
            dd("boom");
        }

        $Today = new Attendance();
        $Today->user_id = Auth::user()->id;
        $Today->check_in_time = now();
        $Today->check_out_time = '';
        $Today->date = $Now_Date;
        $Today->save();

        Session::put("checkin", "done");

        return redirect()->route("user.Dashboard");
    }

    // Check Out
    public function Attendance_Check_OUT(Request $request)
    {
        $Now_Date = now()->toDateString();
        $Now_Time = now()->toTimeString();

        $Find_Attendace_Record = Attendance::where('date', $Now_Date)
            ->where('user_id', Auth::user()->id)->first();

        $Find_Attendace_Record->check_out_time = now();
        $Find_Attendace_Record->save();

        Session::forget("checkin");

        return redirect()->route("user.Dashboard");
    }
}
