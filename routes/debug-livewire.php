<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| TEST 1: Sesión y cookies
|--------------------------------------------------------------------------
*/

Route::get('/debug/signed-test', function () {
    $url = URL::temporarySignedRoute(
        'livewire.preview-file',
        now()->addMinutes(5),
        ['filename' => 'test.png']
    );

    return [
        'generated_url' => $url,
        'current_scheme' => request()->getScheme(),
        'trusted_proxies' => request()->headers->get('x-forwarded-proto'),
        'app_url' => config('app.url'),
    ];
});

Route::get('/debug/session', function (Request $request) {

    return response()->json([
        'app_url' => config('app.url'),
        'request_host' => $request->getHost(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'session_same_site' => config('session.same_site'),

        'session_started' => Session::isStarted(),
        'session_id' => Session::getId(),

        'has_laravel_session_cookie' => $request->cookies->has('laravel_session'),
        'cookies' => array_keys($request->cookies->all()),

        'storage_sessions_writable' => is_writable(storage_path('framework/sessions')),
    ]);
})->middleware('web');


/*
|--------------------------------------------------------------------------
| TEST 2: Autenticación
|--------------------------------------------------------------------------
*/
Route::get('/debug/auth', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::id(),
    ]);
})->middleware(['web', 'auth']);


/*
|--------------------------------------------------------------------------
| TEST 3: Livewire routes activos
|--------------------------------------------------------------------------
*/
Route::get('/debug/livewire-routes', function () {
    return response()->json([
        'update_route' => route('livewire.update', [], false),
        'script_route' => url('/livewire/livewire.min.js'),
        'preview_route_example' => url('/livewire/preview-file/test.png'),
    ]);
})->middleware('web');


/*
|--------------------------------------------------------------------------
| TEST 4: Preview route directo (simulación)
|--------------------------------------------------------------------------
*/
Route::get('/debug/preview-test', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'Preview route reached successfully',
        'user' => Auth::id(),
    ]);
})->middleware('web');


/*
|--------------------------------------------------------------------------
| TEST 5: Cookie manual
|--------------------------------------------------------------------------
*/
Route::get('/debug/cookie', function () {
    Cookie::queue(
        Cookie::make(
            'debug_cookie',
            'ok',
            10,
            '/',
            config('session.domain'),
            true,
            false,
            false,
            config('session.same_site')
        )
    );

    return response()->json([
        'cookie_set' => true
    ]);
})->middleware('web');
