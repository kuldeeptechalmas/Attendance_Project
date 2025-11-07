<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CheckInOut;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    // Check In
    public function Attendance_Check_IN(Request $request)
    {
        $Now_Date = now();

        $Exist_Attendance = Attendance::where("date", $Now_Date)->where("user_id", Auth::user()->id)->first();
        if (isset($Exist_Attendance)) {
            $Checkinout = new CheckInOut();
            $Checkinout->check_in_time = now();
            $Checkinout->check_out_time = '';
            $Checkinout->attandance_id = $Exist_Attendance->id;
            $Checkinout->save();
        } else {
            $Today = new Attendance();
            $Today->user_id = Auth::user()->id;
            $Today->date = $Now_Date;
            $Today->save();

            $Checkinout = new CheckInOut();
            $Checkinout->check_in_time = now();
            $Checkinout->check_out_time = '';
            $Checkinout->attandance_id = $Today->id;
            $Checkinout->save();
        }


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

        $checkinout = CheckInOut::where("attandance_id", $Find_Attendace_Record->id)
            ->orderByDesc("created_at")
            ->first();

        $checkinout->check_out_time = now();
        $checkinout->save();


        Session::forget("checkin");

        return redirect()->route("user.Dashboard");
    }

    // Check in Time Change - (ajax)
    public function Check_IN_Time_Change(Request $request)
    {
        $Find_Check_Record = CheckInOut::find($request->checkinid);
        if (isset($Find_Check_Record)) {
            $Find_Check_Record->check_in_time = $request->checkintime;
            $Find_Check_Record->save();

            $Find_Attendance = Attendance::with("checkinoutdataget")->find($request->attendanceid);

            $totalHover = 0;
            $totalMinute = 0;

            foreach ($Find_Attendance->checkinoutdataget as $check) {

                $time1 = Carbon::parse($check->check_in_time);
                $time2 = Carbon::parse($check->check_out_time);
                $diffrence = $time1->diff($time2);
                $totalHover += $diffrence->h;
                $totalMinute += $diffrence->i;
            }

            if ($totalMinute >= 60) {
                $totalHover += 1;
                $totalMinute -= 60;
            }

            return response()->json([
                'Update' => "done",
                'hover' => $totalHover,
                'minute' => $totalMinute,
            ]);
        } else {
            return response()->json(['Not Found Record']);
        }
    }

    // Check out Time Change - (ajax)
    public function Check_OUT_Time_Change(Request $request)
    {
        $Find_Check_Record = CheckInOut::find($request->checkinid);
        if (isset($Find_Check_Record)) {
            $Find_Check_Record->check_out_time = $request->checkouttime;
            $Find_Check_Record->save();

            $Find_Attendance = Attendance::with("checkinoutdataget")->find($request->attendanceid);

            $totalHover = 0;
            $totalMinute = 0;

            foreach ($Find_Attendance->checkinoutdataget as $check) {

                $time1 = Carbon::parse($check->check_in_time);
                $time2 = Carbon::parse($check->check_out_time);
                $diffrence = $time1->diff($time2);
                $totalHover += $diffrence->h;
                $totalMinute += $diffrence->i;
            }

            if ($totalMinute >= 60) {
                $totalHover += 1;
                $totalMinute -= 60;
            }

            return response()->json([
                'Update' => "done",
                'hover' => $totalHover,
                'minute' => $totalMinute,
            ]);
        } else {
            return response()->json(['Not Found Record']);
        }
    }

    // Check Data Delete
    public function Check_Data_Delete($checkid, Request $request)
    {
        $Find_Check_Data = CheckInOut::find($checkid);
        if (isset($Find_Check_Data)) {
            $Find_Check_Data->delete();
            return redirect()->route('user.Dashboard');
        } else {
            return redirect()->back();
        }
    }
}
