<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    public function option()
    {
        return $this->hasOne(Option::class);
        // note: we can also inlcude Mobile model like: 'App\Mobile'
    }
}
