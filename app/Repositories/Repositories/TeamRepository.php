<?php

namespace App\Repositories\Repositories;

use App\Models\Team;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TeamInterface;

class TeamRepository extends BaseRepository implements TeamInterface
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function createTeam(array $data)
    {
        return $this->firstOrCreate($data);
    }

    public function getTeams()
    {
        return $this->get();
    }
}
