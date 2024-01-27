<?php

namespace App\Controllers;

use Response;

class DashboardController extends Controller
{
    /**
     * Verify if user is logged.
     */
    public function __construct()
    {
        $this->middleware('Auth');
    }

    /**
     * Show home page.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response()->json(['message' => lang('You are logged in') ]);
    }
}
