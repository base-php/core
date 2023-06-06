
// Auth
$route->auth();

// Dashboard
$route->get('/dashboard', [DashboardController::class, 'index']);

// Users
$route->resource('/dashboard/users', UserController::class);
