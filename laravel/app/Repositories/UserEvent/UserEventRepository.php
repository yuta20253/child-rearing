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

    public function getUserEvents(int $userId, ?DateTime $targetDate): Collection
    {
        return $this
            ->user
            ->findOrFail($userId)
            ->events()
            ->whereDate('start_datetime', $targetDate
            ->format('Y-m-d'))
            ->orderBy('start_datetime')
            ->get();
    }
}
