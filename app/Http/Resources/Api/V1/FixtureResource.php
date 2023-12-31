<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FixtureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'league_id' => $this->league_id,
            'week' => $this->week,
            'home_team_id' => $this->home_team_id,
            'away_team_id' => $this->away_team_id,
            'is_played' => $this->is_played,
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
            'home_team' => TeamResource::make($this->whenLoaded('homeTeam')),
            'away_team' => TeamResource::make($this->whenLoaded('awayTeam')),
            'league' => LeagueResource::make($this->whenLoaded('league')),
        ];
    }
}
