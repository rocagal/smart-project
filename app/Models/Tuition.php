<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tuition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function StudentTeacherHomeroomRelationship()
    {
        return $this->belongsTo(StudentTeacherHomeroomRelationship::class);
    }
    
    public function tuitionDetails()
    {
        return $this->hasMany(TuitionDetail::class);
    }
}
