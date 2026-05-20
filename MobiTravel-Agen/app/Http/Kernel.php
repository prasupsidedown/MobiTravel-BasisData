protected $routeMiddleware = [
    // ... middleware yang sudah ada
    'auth.agen' => \App\Http\Middleware\AuthAgen::class,
];