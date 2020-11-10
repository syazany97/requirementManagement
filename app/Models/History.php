<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    const MORPH_NAME = 'historyable';
    use HasFactory;

    public function historyable()
    {
        return $this->morphTo();
    }
}
