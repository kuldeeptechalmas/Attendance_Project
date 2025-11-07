<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "attendance";
    protected $fillable = [
        "user_id",
        "date",
    ];

    public function checkinoutdataget()
    {
        return $this->hasMany(CheckInOut::class, 'attandance_id', 'id');
    }
}
