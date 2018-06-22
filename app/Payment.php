<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    public function detail()
    {
        return $this->hasMany(Payment_detail::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
