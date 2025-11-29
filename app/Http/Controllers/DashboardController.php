<?php

namespace App\Http\Controllers;

use App\Models\GlobalFine;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total statistics
        $totalFines = GlobalFine::count();
        $totalAmount = GlobalFine::sum('fine_amount');
        $averageAmount = GlobalFine::avg('fine_amount');
        $latestFineDate = GlobalFine::orderBy('fine_date', 'desc')->first()?->fine_date;
    // formatted display strings (move presentation logic out of blade)
    $formattedTotal = '€' . number_format($totalAmount / 1000000000, 1) . 'B';
    $formattedAverage = '€' . number_format(($averageAmount ?? 0) / 1000000, 1) . 'M';

        // Regulators statistics
        $regulatorStats = GlobalFine::select('regulator', DB::raw('COUNT(*) as count'), DB::raw('SUM(fine_amount) as total_amount'))
            ->groupBy('regulator')
            ->orderBy('count', 'desc')
            ->get();
        // compute percent relative to top regulator to use in bar widths
        $regMax = $regulatorStats->first()?->count ?? 1;
        $regulatorStats = $regulatorStats->map(function($s) use ($regMax) {
            $s->percent = round(($s->count / $regMax) * 100, 1);
            $s->formatted_total = '€' . number_format($s->total_amount / 1000000, 1) . 'M';
            return $s;
        });

        // Sectors statistics
        $sectorStats = GlobalFine::select('sector', DB::raw('COUNT(*) as count'), DB::raw('SUM(fine_amount) as total_amount'))
            ->groupBy('sector')
            ->orderBy('count', 'desc')
            ->get();
        $secMax = $sectorStats->first()?->count ?? 1;
        $sectorStats = $sectorStats->map(function($s) use ($secMax) {
            $s->percent = round(($s->count / $secMax) * 100, 1);
            $s->formatted_total = '€' . number_format($s->total_amount / 1000000, 1) . 'M';
            return $s;
        });

        // Violation types statistics
        $violationStats = GlobalFine::select('violation_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(fine_amount) as total_amount'))
            ->groupBy('violation_type')
            ->orderBy('count', 'desc')
            ->get();
        $vioMax = $violationStats->first()?->count ?? 1;
        $violationStats = $violationStats->map(function($s) use ($vioMax) {
            $s->percent = round(($s->count / $vioMax) * 100, 1);
            $s->formatted_total = '€' . number_format($s->total_amount / 1000000, 1) . 'M';
            return $s;
        });

        // Year-over-year statistics
        $yearlyStats = GlobalFine::select(
            DB::raw('YEAR(fine_date) as year'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(fine_amount) as total_amount')
        )
        ->groupBy(DB::raw('YEAR(fine_date)'))
        ->orderBy('year', 'desc')
        ->get();
        $yearMax = $yearlyStats->first()?->count ?? 1;
        $yearlyStats = $yearlyStats->map(function($s) use ($yearMax) {
            $s->percent = round(($s->count / $yearMax) * 100, 1);
            $s->formatted_total = '€' . number_format($s->total_amount / 1000000, 0) . 'M';
            return $s;
        });

        // Monthly trends (last 12 months)
        $monthlyStats = GlobalFine::select(
            DB::raw('DATE_FORMAT(fine_date, "%Y-%m") as month'),
            DB::raw('COUNT(*) as count'),
            DB::raw('SUM(fine_amount) as total_amount')
        )
        ->where('fine_date', '>=', now()->subMonths(12))
        ->groupBy(DB::raw('DATE_FORMAT(fine_date, "%Y-%m")'))
        ->orderBy('month', 'desc')
        ->get();

        // Top 10 largest fines
        $largestFines = GlobalFine::orderBy('fine_amount', 'desc')
            ->limit(10)
            ->get();

        // Top organizations (most fined)
        $topOrganizations = GlobalFine::select('organisation', 'regulator', 'sector', DB::raw('COUNT(*) as count'), DB::raw('SUM(fine_amount) as total_amount'))
            ->groupBy('organisation', 'regulator', 'sector')
            ->orderBy('total_amount', 'desc')
            ->limit(10)
            ->get();

        // Countries/Regions statistics
        $regionStats = GlobalFine::select('region', DB::raw('COUNT(*) as count'), DB::raw('SUM(fine_amount) as total_amount'))
            ->groupBy('region')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        $regnMax = $regionStats->first()?->count ?? 1;
        $regionStats = $regionStats->map(function($s) use ($regnMax) {
            $s->percent = round(($s->count / $regnMax) * 100, 1);
            $s->formatted_total = '€' . number_format($s->total_amount / 1000000, 0) . 'M';
            return $s;
        });

        // prepare simplified dashboard data for client-side exports (XLSX)
        $dashboardData = [
            'regulators' => $regulatorStats->map(function($s){
                return [
                    'regulator' => $s->regulator,
                    'count' => $s->count,
                    'total' => $s->formatted_total ?? null,
                    'percent' => $s->percent,
                ];
            })->toArray(),
            'sectors' => $sectorStats->map(function($s){
                return [
                    'sector' => $s->sector,
                    'count' => $s->count,
                    'total' => $s->formatted_total ?? null,
                    'percent' => $s->percent,
                ];
            })->toArray(),
            'violations' => $violationStats->map(function($s){
                return [
                    'violation_type' => $s->violation_type,
                    'count' => $s->count,
                    'total' => $s->formatted_total ?? null,
                    'percent' => $s->percent,
                ];
            })->toArray(),
            'yearly' => $yearlyStats->map(function($s){
                return [
                    'year' => $s->year,
                    'count' => $s->count,
                    'total' => $s->formatted_total ?? null,
                    'percent' => $s->percent,
                ];
            })->toArray(),
            'regions' => $regionStats->map(function($s){
                return [
                    'region' => $s->region,
                    'count' => $s->count,
                    'total' => $s->formatted_total ?? null,
                    'percent' => $s->percent,
                ];
            })->toArray(),
            'organizations' => $topOrganizations->map(function($o){
                return [
                    'organisation' => $o->organisation,
                    'sector' => $o->sector,
                    'regulator' => $o->regulator,
                    'cases' => $o->count,
                    'total' => '€' . number_format($o->total_amount / 1000000, 1) . 'M',
                ];
            })->toArray(),
            'largest' => $largestFines->map(function($f){
                return [
                    'organisation' => $f->organisation,
                    'regulator' => $f->regulator,
                    'sector' => $f->sector,
                    'amount' => '€' . number_format($f->fine_amount / 1000000, 1) . 'M',
                    'date' => $f->fine_date,
                    'violation_type' => $f->violation_type,
                ];
            })->toArray(),
        ];

    // expose formatted values to view
    // $formattedTotal and $formattedAverage are already set above

        return view('dashboards', compact(
            'totalFines',
            'totalAmount',
            'averageAmount',
            'latestFineDate',
            'formattedTotal',
            'formattedAverage',
            'regulatorStats',
            'sectorStats',
            'violationStats',
            'yearlyStats',
            'monthlyStats',
            'largestFines',
            'topOrganizations',
            'regionStats',
            'dashboardData'
        ));

    }

}
