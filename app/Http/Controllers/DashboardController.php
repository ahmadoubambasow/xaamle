<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService
    ) {}

    /**
     * Afficher le dashboard.
     */
    public function index(Request $request): View
    {
        $data = $this->dashboardService->getDashboardData(
            $request->user()
        );

        return view('dashboard', $data);
    }
}