<?php

namespace App\Repositories\UserEvent;

use DateTime;
use Illuminate\Database\Eloquent\Collection;

interface UserEventRepositoryInterface
{
    public function getUserEvents(int $id, ?DateTime $targetDate): Collection;
}
