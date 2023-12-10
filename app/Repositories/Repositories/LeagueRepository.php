<?php

namespace App\Repositories\Repositories;

use App\Models\League;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\LeagueInterface;
use Illuminate\Database\Eloquent\Model;

class LeagueRepository extends BaseRepository implements LeagueInterface
{
    public function __construct(League $model)
    {
        parent::__construct($model);
    }

    public function createLeague(array $data)
    {
        return $this->create($data);
    }

    public function findOrFailLeague(int $id)
    {
        return $this->findOrFail($id);
    }

    public function updateLeague(int $league_id, array $data)
    {
        return $this->update($league_id, $data);
    }

    public function getScoreboards(int $league_id)
    {
        $league = $this->findOrFailLeague($league_id);

        return $league->scoreboards;
    }
}
