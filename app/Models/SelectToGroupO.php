<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectToGroupO extends Model
{
    use HasFactory;

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function tts()
    {
        return $this->belongsTo(TeacherToSciense::class, 'teacher_to_sciense_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
