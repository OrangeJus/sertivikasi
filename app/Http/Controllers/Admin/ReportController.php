<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Genset;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $period = $request->get('period', '12months'); // 12months or custom
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // KPIs
        $totalRentals = Rental::count();
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('amount');
        $activeRentals = Rental::where('status', 'active')->count();
        $monthlyRevenue = Payment::where('payment_status', 'paid')
            ->whereBetween('payment_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        // Charts data based on period
        if ($period === '12months') {
            // Last 12 months
            $revenuePerMonth = Payment::select(
                    DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month"),
                    DB::raw('SUM(amount) as total')
                )
                ->where('payment_status', 'paid')
                ->where('payment_date', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('month')
                ->orderBy('month')
                ->get()
                ->pluck('total', 'month');

            $chartTitle = 'Pendapatan 12 Bulan Terakhir';
            $chartData = collect();
            for ($i = 11; $i >= 0; $i--) {
                $monthKey = now()->subMonths($i)->format('Y-m');
                $chartData->put($monthKey, $revenuePerMonth->get($monthKey, 0));
            }
        } else {
            // Specific year-month
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();

            $revenuePerDay = Payment::select(
                    DB::raw("DATE_FORMAT(payment_date, '%Y-%m-%d') as day"),
                    DB::raw('SUM(amount) as total')
                )
                ->where('payment_status', 'paid')
                ->whereBetween('payment_date', [$startDate, $endDate])
                ->groupBy('day')
                ->orderBy('day')
                ->get()
                ->pluck('total', 'day');

            $chartTitle = 'Pendapatan ' . Carbon::create($year, $month, 1)->format('F Y');
            $chartData = collect();
            $daysInMonth = $startDate->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $dayKey = Carbon::create($year, $month, $i)->format('Y-m-d');
                $chartData->put($dayKey, $revenuePerDay->get($dayKey, 0));
            }
        }

        // top genset
        $topGensets = Rental::select('genset_id', DB::raw('count(*) as total_rentals'))
            ->groupBy('genset_id')
            ->orderByDesc('total_rentals')
            ->with('genset')
            ->take(5)->get();

        // category counts
        $perCategory = Category::withCount(['gensets as rentals_count' => function($q) {
            $q->join('rentals', 'rentals.genset_id', 'gensets.id')
              ->select(DB::raw('count(rentals.id)'));
        }])->get();

        return view('admin.reports.index', compact(
            'totalRentals', 'totalRevenue', 'activeRentals', 'monthlyRevenue',
            'chartData', 'chartTitle', 'topGensets', 'perCategory', 'period', 'year', 'month'
        ));
    }

    // endpoint untuk tabel rental (filterable)
    public function rentals(Request $request)
    {
        $q = Rental::with(['user', 'genset.categories', 'payment']);

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        if ($request->filled('user_id')) {
            $q->where('user_id', $request->user_id);
        }
        if ($request->filled('genset_id')) {
            $q->where('genset_id', $request->genset_id);
        }
        if ($request->filled('from') && $request->filled('to')) {
            $q->whereBetween('tanggal_mulai', [$request->from, $request->to]);
        }

        $rentals = $q->orderBy('tanggal_mulai', 'desc')->paginate(15)->withQueryString();
        
        // jika ajax request, kembalikan partial / json
        if ($request->ajax()) {
            return view('admin.reports.partials.rentals_table', compact('rentals'))->render();
        }
        
        return view('admin.reports.rentals', compact('rentals'));
    }

    // export CSV (simple)
    public function export(Request $request)
    {
        $type = $request->get('type', 'csv'); // csv/pdf
        $from = $request->get('from');
        $to = $request->get('to');

        $query = Rental::with(['user', 'genset']);
        if ($from && $to) $query->whereBetween('tanggal_mulai', [$from, $to]);

        if ($type === 'csv') {
            $response = new StreamedResponse(function() use ($query) {
                $handle = fopen('php://output', 'w');
                // header CSV
                fputcsv($handle, ['ID', 'User', 'Genset', 'Start', 'End', 'Total Harga', 'Status']);
                $query->chunk(200, function($rows) use ($handle) {
                    foreach ($rows as $r) {
                        fputcsv($handle, [
                            $r->id,
                            $r->user->name,
                            $r->genset->nama_genset,
                            $r->tanggal_mulai,
                            $r->tanggal_selesai,
                            $r->total_harga,
                            $r->status
                        ]);
                    }
                });
                fclose($handle);
            });

            $fileName = 'rentals_export_' . now()->format('Ymd_His') . '.csv';
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', "attachment; filename={$fileName}");
            return $response;
        }

        // TODO: PDF export (gunakan dompdf/laravel-dompdf)
        abort(404);
    }
}