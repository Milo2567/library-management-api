<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //

    protected $guarded = [];


    public function borrowers(){
        return $this->belongsToMany(User::class)->withPivot("date_borrowed", "date_returned");
    }
}
