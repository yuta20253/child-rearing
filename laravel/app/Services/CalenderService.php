<?php

namespace App\Services;

use App\Repositories\UserEvent\UserEventRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class CalenderService
{
    private UserEventRepository $userEventRepository;

    public function __construct(UserEventRepository $userEventRepository)
    {
        $this->userEventRepository = $userEventRepository;
    }

    public function getMonthlyUserEvents(int $year, int $month)
    {
        $userId = Auth::id();

        $events = $this->userEventRepository->getMonthlyUserEvents($userId, $year, $month);
        return $events;
    }
}
