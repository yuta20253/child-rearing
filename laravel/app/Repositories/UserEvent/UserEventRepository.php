<?php

namespace App\Repositories\UserEvent;

use App\Models\User;
use App\Repositories\UserEvent\UserEventRepositoryInterface;
use DateTime;
use Illuminate\Database\Eloquent\Collection;

class UserEventRepository implements UserEventRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function selectedMonthUserEvents(int $userId, int $year , int $month): Collection
    {
        return $this
            ->user
            ->findOrFail($userId)
            ->events()
            ->whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month)
            ->orderBy('start_datetime')
            ->get();
    }
}
