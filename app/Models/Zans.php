<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zans extends Model
{
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
