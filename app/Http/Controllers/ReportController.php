<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QcHistory;
use App\Models\StockMutation;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Exports\QcReportExport;
use App\Exports\InventoryReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generateQc(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        $query = QcHistory::with('product')->orderBy('date', 'desc');

        if ($start && $end) {
            $query->whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')]);
        }

        $data = $query->get();

        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('reports.qc_pdf', compact('data', 'start', 'end'));
            return $pdf->download('qc_report.pdf');
        } elseif ($request->export === 'excel') {
            // Need an export class
            return Excel::download(new QcReportExport($data), 'qc_report.xlsx');
        }

        return back()->with('error', 'Invalid export format');
    }

    public function generateInventory(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        $query = StockMutation::with('product')->orderBy('created_at', 'desc');

        if ($start && $end) {
            $query->whereBetween('created_at', [$start, $end]);
        }

        $data = $query->get();

        if ($request->export === 'pdf') {
            $pdf = Pdf::loadView('reports.inventory_pdf', compact('data', 'start', 'end'));
            return $pdf->download('inventory_report.pdf');
        } elseif ($request->export === 'excel') {
            return Excel::download(new InventoryReportExport($data), 'inventory_report.xlsx');
        }

        return back()->with('error', 'Invalid export format');
    }
}
