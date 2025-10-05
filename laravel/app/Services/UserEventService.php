<?php

namespace App\Services;

use App\Repositories\UserEvent\UserEventRepository;
use Illuminate\Support\Facades\Auth;

class UserEventService
{
    private UserEventRepository $userEventRepository;

    public function __construct(UserEventRepository $userEventRepository)
    {
        $this->userEventRepository = $userEventRepository;
    }

    public function getUserEvents()
    {
        $userId = Auth::id();
        $userEvents = $this->userEventRepository->getUserEvents($userId);

        return $userEvents->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_datetime' => $event->start_datetime,
                'end_datetime' => $event->end_datetime,
                'capacity' => $event->capacity,
                'memo' => $event->pivot->memo,
            ];
        })->toArray();
    }

}
