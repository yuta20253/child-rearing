<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if (! $request->is('api/*')) return;

            if (str_contains($e->getMessage(), 'Facility')) {
                $message = '該当の施設が見つかりません。';
            } elseif (str_contains($e->getMessage(), 'User')) {
                $message = '該当のユーザーが見つかりません。';
            } else {
                $message = 'リソースが見つかりません。';
            }

            return response()->json([
                'message' => $message ?? 'リソースが見つかりません。',

            ], 404);
        });
    }
}
