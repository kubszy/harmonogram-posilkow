<?php

namespace App;

use App\Harmonogram;

use Illuminate\Database\Eloquent\Model;

class Posilek extends Model
{
    protected $table = 'posilek';

    public function harmonogram()
    {
        return $this->belongsTo(harmonogram::class);
    }
}
