<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scoreboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'played',
        'won',
        'lost',
        'scores_out',
        'scores_in',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
