<?php

namespace App\Repositories\UserEvent;

use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface UserEventRepositoryInterface
{
    public function getMonthlyUserEvents(int $id, int $year, int $month): Collection;
}
