<?php

namespace App\View\Composers;

use App\Services\DashboardStatisticsService;
use Illuminate\View\View;

class DashboardComposer
{
    protected DashboardStatisticsService $statisticsService;

    public function __construct(
        DashboardStatisticsService $statisticsService
    ) {
        $this->statisticsService = $statisticsService;
    }

    public function compose(View $view): void
    {
        $statistics = $this->statisticsService->getStatistics();

        $view->with($statistics);
    }
}
