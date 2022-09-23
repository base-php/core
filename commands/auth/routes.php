
// Auth
$route->auth();

// Dashboard
$route->get('/dashboard', [DashboardController::class, 'index']);

// Users
$route->resource('/dashboard/users', UserController::class);
$route->get('/dashboard/users/2fa/{id}', [UserController::class, 'two_fa']);
