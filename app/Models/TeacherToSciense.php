<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherToSciense extends Model
{
    use HasFactory;

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function sciense()
    {
        return $this->belongsTo(Sciense::class, 'sciense_id');
    }
}
