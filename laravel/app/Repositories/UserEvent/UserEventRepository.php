<?php

namespace App\Repositories\UserEvent;

use App\Models\User;
use App\Repositories\UserEvent\UserEventRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserEventRepository implements UserEventRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUserEvents(int $userId): Collection
    {
        return $this->user->findOrFail($userId)->events()->get();
    }
}
