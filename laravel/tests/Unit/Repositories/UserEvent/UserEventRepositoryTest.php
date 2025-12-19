<?php

namespace Tests\Unit\Repositories\UserEvent;

use App\Models\User;
use App\Models\Event;
use App\Repositories\UserEvent\UserEventRepository;
use App\Repositories\UserEvent\UserEventRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserEventRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private UserEventRepositoryInterface $userEventRepository;

    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        app()->bind(UserEventRepositoryInterface::class, UserEventRepository::class);
        $this->userEventRepository = app(UserEventRepositoryInterface::class);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function 指定した年月のユーザーイベントが取得されること(): void
    {
        $user = User::factory()->create();

        $mayEventInMonth = Event::factory()->create([
            'start_datetime' => '2025-05-10 10:00:00',
        ]);

        $juneEventInMonth = Event::factory()->create([
            'start_datetime' => '2025-06-11 10:00:00',
        ]);

        $user->events()->attach($mayEventInMonth->id);
        $user->events()->attach($juneEventInMonth->id);

        $events = $this->userEventRepository->getMonthlyUserEvents($user->id, 2025, 5);

        $this->assertCount(1, $events);
        $this->assertTrue($events->contains($mayEventInMonth));
        $this->assertFalse($events->contains($juneEventInMonth));
    }
}
