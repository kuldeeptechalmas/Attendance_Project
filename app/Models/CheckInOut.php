<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInOut extends Model
{
    use HasFactory;
    protected $table = "checkinout";
    protected $fillable = [
        "check_in_time",
        "check_out_time",
        "attandance_id",
    ];

    public function attendancedata()
    {
        return $this->belongsTo(Attendance::class, 'id', 'attandance_id');
    }
}
