<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function admin()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }
}
