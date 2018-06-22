<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function detail()
    {
        return $this->hasManyThrough(Payment_detail::class, Payment::class);
    }
}
