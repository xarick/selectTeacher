<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sciense extends Model
{
    use HasFactory;

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }
}
