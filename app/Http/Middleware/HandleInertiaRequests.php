<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            // Lazily...
            'auth.user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email')
                : null,
            'auth.role' => fn () => $request->user()
                ? $request->user()->roles?->first()?->name
                : null,
            'flash' => [
                'error' => fn () => $request->session()->get('error')
            ],
            'auth.client' => function () use ($request) {
                return $request->user() ? $request->user()->client : null;
            },
        ]);
    }

    public function rootView(Request $request): string
    {
        if (preg_match('/admin/', $request->route()->getPrefix())) {
            return 'app';
        }

        return 'guest';
    }
}
