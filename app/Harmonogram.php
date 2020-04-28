<?php

namespace App;

use App\Posilek;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Harmonogram extends Model
{
    protected $table = 'harmonogram';


    public function posilek()
    {
        return $this->hasMany(posilek::class);
    }

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
