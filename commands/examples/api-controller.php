<?php

namespace App\Controllers;

use Response;

class HomeController extends Controller
{
    /**
     * Show home page.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response()->json(['Base PHP']);
    }
}
