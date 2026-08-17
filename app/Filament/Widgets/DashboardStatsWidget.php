<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $newApplications = JobApplication::where('status', 'new')->count();

        return [
            Stat::make('Categories', Category::count())
                ->description('Therapeutic areas')
                ->icon('heroicon-o-rectangle-stack')
                ->color('info'),

            Stat::make('Products', Product::count())
                ->description(Product::where('is_featured', true)->count().' featured on homepage')
                ->icon('heroicon-o-beaker')
                ->color('success'),

            Stat::make('Job Openings', JobOpening::where('is_active', true)->count())
                ->description('Published on careers page')
                ->icon('heroicon-o-briefcase')
                ->color('warning'),

            Stat::make('CVs Received', JobApplication::count())
                ->description($newApplications.' awaiting review')
                ->icon('heroicon-o-inbox-arrow-down')
                ->color($newApplications > 0 ? 'danger' : 'success'),
        ];
    }
}
