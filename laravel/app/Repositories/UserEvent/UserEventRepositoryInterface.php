<?php

namespace App\Repositories\UserEvent;

use Illuminate\Database\Eloquent\Collection;

interface UserEventRepositoryInterface
{
    public function getUserEvents(int $id): Collection;
}
