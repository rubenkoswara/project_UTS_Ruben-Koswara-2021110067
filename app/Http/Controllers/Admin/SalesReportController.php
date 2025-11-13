<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\Response;
use App\Models\Order; 

use Barryvdh\DomPDF\Facade\Pdf; 


class SalesReportController extends Controller
{
    protected const COMPLETED_STATUS = 'Selesai';
    
    private function getRawSalesData(): Collection
    {
        Carbon::setLocale('id');

        return Order::with('user')->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'customer' => $order->user->name,
                'total' => $order->total,
                'date' => $order->created_at,
                'status' => $order->status,
            ];
        });
    }

    private function calculateDateRange(string $filter, ?string $customStart = null, ?string $customEnd = null): array
    {
        Carbon::setLocale('id'); 
        $now = Carbon::now();
        $start_date = null;
        $end_date = null;
        $label = 'Keseluruhan Data';
        $is_custom = false;

        if ($filter === 'today') {
            $start_date = $now->copy()->startOfDay();
            $end_date = $now->copy()->endOfDay();
            $label = 'Hari Ini (' . $now->translatedFormat('d F Y') . ')';
        } elseif ($filter === 'weekly') {
            $start_date = $now->copy()->startOfWeek();
            $end_date = $now->copy()->endOfDay();
            $label = 'Minggu Ini (' . $start_date->translatedFormat('d F') . ' - ' . $end_date->translatedFormat('d F Y') . ')';
        } elseif ($filter === 'monthly') {
            $start_date = $now->copy()->startOfMonth();
            $end_date = $now->copy()->endOfDay();
            $label = 'Bulan ' . $now->translatedFormat('F Y');
        } elseif ($filter === 'custom' && $customStart && $customEnd) {
            try {
                $start_date = Carbon::parse($customStart)->startOfDay();
                $end_date = Carbon::parse($customEnd)->endOfDay();
                $label = 'Periode Kustom (' . $start_date->translatedFormat('d F Y') . ' - ' . $end_date->translatedFormat('d F Y') . ')';
                $is_custom = true;
            } catch (\Exception $e) {
                $filter = 'all';
                $label = 'Keseluruhan Data';
            }
        }
        
        return [
            'start_date' => $start_date ? $start_date->toDateString() : null,
            'end_date' => $end_date ? $end_date->toDateString() : null,
            'label' => $label, 
            'is_custom' => $is_custom,
        ];
    }

    private function getFilteredSalesData(string $filter, ?string $customStart = null, ?string $customEnd = null): array
    {
        Carbon::setLocale('id');

        $allSales = $this->getRawSalesData();
        $range = $this->calculateDateRange($filter, $customStart, $customEnd);

        $completed_sales = $allSales->filter(fn($s) => $s['status'] === self::COMPLETED_STATUS);
        
        $filtered_sales = $completed_sales->filter(function ($sale) use ($range) {
            if (!$range['start_date'] || !$range['end_date']) {
                return true; 
            }

            $date = $sale['date'];
            $start = Carbon::parse($range['start_date'])->startOfDay();
            $end = Carbon::parse($range['end_date'])->endOfDay();

            return $date->between($start, $end);
        })->values();

        $total_revenue = $filtered_sales->sum('total');
        $total_orders = $filtered_sales->count();
        $average_sale = $total_orders > 0 ? $total_revenue / $total_orders : 0;

        $sales_data_formatted = $filtered_sales->map(function ($sale) {
            $sale['total_formatted'] = 'Rp ' . number_format($sale['total'], 0, ',', '.');
            $sale['date_formatted'] = $sale['date']->translatedFormat('d F Y'); 
            return $sale;
        });

        return [
            'sales' => $sales_data_formatted,
            'raw_data' => $filtered_sales->toArray(), 
            'total_revenue' => 'Rp ' . number_format($total_revenue, 0, ',', '.'),
            'total_orders' => $total_orders,
            'average_sale' => 'Rp ' . number_format($average_sale, 0, ',', '.'),
            'filter' => $filter,
            'range_label' => $range['label'],
            'start_date' => $range['start_date'],
            'end_date' => $range['end_date'],
            'is_custom' => $range['is_custom'],
        ];
    }
    
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'monthly');
        $customStart = $request->get('start_date_custom');
        $customEnd = $request->get('end_date_custom');
        
        $data = $this->getFilteredSalesData($filter, $customStart, $customEnd);
        
        $data['orders'] = $data['sales']; 
        $data['custom_start_date'] = $customStart;
        $data['custom_end_date'] = $customEnd;


        return view('admin.sales_report', array_merge($data, ['filter' => $filter]));
    }

    public function exportExcel(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $customStart = $request->get('start_date_custom');
        $customEnd = $request->get('end_date_custom');

        $data = $this->getFilteredSalesData($filter, $customStart, $customEnd);
        $exportData = $data['raw_data'];
        
        $range = $this->calculateDateRange($filter, $customStart, $customEnd);
        
        $fileNameSuffix = $range['start_date'] && $range['end_date'] 
                             ? $range['start_date'] . '_to_' . $range['end_date'] 
                             : 'AllData';
        
        $fileName = 'LaporanPenjualan_' . $fileNameSuffix . '_' . Carbon::now()->format('Ymd_His') . '.csv';
        
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function() use ($exportData)
        {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['No. Order', 'Tanggal', 'Customer', 'Total Penjualan', 'Status']);

            foreach ($exportData as $sale) {
                $dateString = Carbon::parse($sale['date'])->toDateString();
                
                fputcsv($file, [
                    $sale['id'],
                    $dateString,
                    $sale['customer'],
                    $sale['total'],
                    $sale['status']
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $customStart = $request->get('start_date_custom');
        $customEnd = $request->get('end_date_custom');

        $data = $this->getFilteredSalesData($filter, $customStart, $customEnd);
        $exportData = $data['sales']; 
        
        $range = $this->calculateDateRange($filter, $customStart, $customEnd);
        
        $fileNameSuffix = $range['start_date'] && $range['end_date'] 
                             ? $range['start_date'] . '_to_' . $range['end_date'] 
                             : 'AllData';
        
        $fileName = 'LaporanPenjualan_' . $fileNameSuffix . '_' . Carbon::now()->format('Ymd_His') . '.pdf';

        $pdf = Pdf::loadView('exports.sales_pdf', [
            'sales' => $exportData,
            'total_revenue' => $data['total_revenue'],
            'total_orders' => $data['total_orders'],
            'range_label' => $data['range_label'], 
            'start_date' => $range['start_date'],
            'end_date' => $range['end_date']
        ]);

        return $pdf->download($fileName); 
    }
}
