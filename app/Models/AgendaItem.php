<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgendaItem extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
    ];
}
