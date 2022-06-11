<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectToStudent extends Model
{
    use HasFactory;

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function stgo()
    {
        return $this->belongsTo(SelectToGroupO::class, 'select_to_group_o_id');
    }
}
