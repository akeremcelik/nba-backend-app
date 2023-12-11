<?php

namespace App\Repositories\Repositories;

use App\Models\Scoreboard;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ScoreboardInterface;

class ScoreboardRepository extends BaseRepository implements ScoreboardInterface
{
    public function __construct(Scoreboard $model)
    {
        parent::__construct($model);
    }

    public function createScoreboard(array $data)
    {
        return $this->create($data);
    }

    public function updateScoreboard(int $id, array $data)
    {
        return $this->update($id, $data);
    }
}
