<?php

namespace App\Repositories\Repositories;

use App\Models\Scoreboard;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ScoreboardInterface;
use Illuminate\Database\Eloquent\Model;

class ScoreboardRepository extends BaseRepository implements ScoreboardInterface
{
    public function __construct(Scoreboard $model)
    {
        parent::__construct($model);
    }

    public function updateOrCreateScoreboard($data1, $data2)
    {
        return $this->updateOrCreate($data1, $data2);
    }
}
