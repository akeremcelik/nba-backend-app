<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'week',
        'home_team_id',
        'away_team_id',
        'is_played',
        'home_team_score',
        'away_team_score',
    ];

    public function scopeLeagueId(Builder $query, int $league_id): void
    {
        $query->where('league_id', $league_id);
    }

    public function scopeWeek(Builder $query, int $week): void
    {
        $query->where('week', $week);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
