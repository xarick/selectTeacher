<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function scienses()
    {
        return $this->hasMany(Sciense::class);
    }
}
