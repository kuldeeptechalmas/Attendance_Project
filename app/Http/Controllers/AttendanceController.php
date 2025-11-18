<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CheckInOut;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function Add_Attendance_Employee(Request $request)
    {
        if ($request->isMethod('post')) {

            $validator = Validator::make(
                $request->all(),
                [
                    'date' => 'required',
                    'checkin' => 'required',
                    'checkout' => 'required',
                ],
                [
                    'date.required' => 'Enter Date is Required.',
                    'checkin.required' => 'Enter Check In Time is Required.',
                    'checkout.required' => 'Enter Check Out is Time Required.',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $find_attendance_exist = Attendance::where('user_id', $request->userid)
                ->where('date', $request->date)->first();
            if (isset($find_attendance_exist)) {
                $checkinout = new CheckInOut();
                $checkinout->check_in_time = $request->checkin;
                $checkinout->check_out_time = $request->checkout;
                $checkinout->attandance_id = $find_attendance_exist->id;
                if ($request->break) {
                    $checkinout->break = $request->break;
                } else {
                    $checkinout->break = '';
                }
                $checkinout->save();
            } else {
                $attendance = new Attendance();
                $attendance->user_id = $request->userid;
                $attendance->date = $request->date;
                $attendance->save();

                $checkinout = new CheckInOut();
                $checkinout->check_in_time = $request->checkin;
                $checkinout->check_out_time = $request->checkout;
                if ($request->break) {
                    $checkinout->break = $request->break;
                } else {
                    $checkinout->break = '';
                }
                $checkinout->attandance_id = $attendance->id;
                $checkinout->save();
            }
            // months wise

            if (isset($find_attendance_exist)) {
                $userid = $find_attendance_exist->id;
            } else {
                $userid = $request->userid;
            }

            $months = now()->createFromDate($request->date)->month;
            $years = now()->createFromDate($request->date)->year;
            return redirect()->route('month.attendance.show', [
                'month' => $months,
                'year' => $years
            ]);
        }
        $find_employee = User::find($request->userid);
        return view('UserPanel.addattendance', ['userid' => $request->userid, 'employee' => $find_employee]);
    }

    // Today Attendance Delete
    public function Today_Attandance_Delete($attendanceid, Request $request)
    {
        $Remove_Attandance = Attendance::find($attendanceid);
        if (isset($Remove_Attandance)) {
            $Remove_Attandance->delete();
            return redirect()->back()->with(['delete' => 'yes']);
        } else {
            return redirect()->back()->with("error", "Not Found Data");
        }
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
            $totalBreakHover = 0;
            $totalBreakMinute = 0;

            foreach ($Find_Attendance->checkinoutdataget as $check) {
                if ($check->check_out_time != '00:00:00') {

                    $time1 = now()::parse($check->check_in_time);
                    $time2 = now()::parse($check->check_out_time);
                    $diffrence = $time1->diff($time2);
                    $totalHover += $diffrence->h;
                    $totalMinute += $diffrence->i;
                    if ($totalMinute > 60) {
                        $totalHover += 1;
                        $totalMinute -= 60;
                    }
                    if ($check->break != null) {

                        $time1 = now()::parse($check->check_in_time);
                        $time2 = now()::parse($check->check_out_time);
                        $diffrence = $time1->diff($time2);
                        $totalBreakHover += $diffrence->h;
                        $totalBreakMinute += $diffrence->i;

                        if ($totalBreakMinute >= 60) {
                            $totalBreakHover += 1;
                            $totalBreakMinute -= 60;
                        }
                    }
                }
            }

            $totalHover -= $totalBreakHover;
            $totalMinute -= $totalBreakMinute;

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
            $totalBreakHover = 0;
            $totalBreakMinute = 0;

            foreach ($Find_Attendance->checkinoutdataget as $check) {
                if ($check->check_out_time != '00:00:00') {

                    $time1 = now()::parse($check->check_in_time);
                    $time2 = now()::parse($check->check_out_time);
                    $diffrence = $time1->diff($time2);
                    $totalHover += $diffrence->h;
                    $totalMinute += $diffrence->i;

                    if ($totalMinute > 60) {
                        $totalHover += 1;
                        $totalMinute -= 60;
                    }
                    if ($check->break != null) {

                        $time1 = now()::parse($check->check_in_time);
                        $time2 = now()::parse($check->check_out_time);
                        $diffrence = $time1->diff($time2);
                        $totalBreakHover += $diffrence->h;
                        $totalBreakMinute += $diffrence->i;

                        if ($totalBreakMinute >= 60) {
                            $totalBreakHover += 1;
                            $totalBreakMinute -= 60;
                        }
                    }
                }
            }

            $totalHover -= $totalBreakHover;
            $totalMinute -= $totalBreakMinute;

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
    public function Check_Data_Delete(Request $request)
    {

        $Find_Check_Data = CheckInOut::find($request->checkid);
        $find_attendance = Attendance::find($Find_Check_Data->attandance_id);

        $userid = $find_attendance->user_id;
        $date = $find_attendance->date;
        $months = now()->createFromDate($date)->month;
        $years = now()->createFromDate($date)->year;

        if (isset($Find_Check_Data)) {
            $Find_Check_Data->delete();
            if (count($find_attendance->checkinoutdataget) == 0) {
                $find_attendance->delete();
            }
            Session::put('checkinout_delete', 'yes');
            return redirect()->route('month.attendance.show', [
                'month' => $months,
                'year' => $years,
            ]);
        } else {
            return redirect()->back();
        }
    }
}
