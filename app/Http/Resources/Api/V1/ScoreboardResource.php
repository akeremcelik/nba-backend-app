<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScoreboardResource extends JsonResource
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
            'team_id' => $this->team_id,
            'played' => $this->played,
            'won' => $this->won,
            'lost' => $this->lost,
            'scores_out' => $this->scores_out,
            'scores_in' => $this->scores_in,
            'league' => LeagueResource::make($this->whenLoaded('league')),
            'team' => TeamResource::make($this->whenLoaded('team')),
        ];
    }
}
