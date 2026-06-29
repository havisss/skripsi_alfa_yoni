<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QcService;
use App\Repositories\Interfaces\QcHistoryRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class QcController extends Controller
{
    protected $qcService;
    protected $qcRepo;
    protected $productRepo;

    public function __construct(
        QcService $qcService,
        QcHistoryRepositoryInterface $qcRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->qcService = $qcService;
        $this->qcRepo = $qcRepo;
        $this->productRepo = $productRepo;
    }

    public function history()
    {
        $histories = $this->qcRepo->paginate(15);
        return view('qc.history', compact('histories'));
    }

    public function upload()
    {
        return view('qc.upload');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ]);

        $result = $this->qcService->processExcelUpload($request->file('file')->getRealPath());

        return response()->json($result);
    }

    public function manual()
    {
        $products = $this->productRepo->all();
        return view('qc.manual', compact('products'));
    }

    public function storeManual(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'po_number' => 'nullable|string',
            'client' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'color' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'status' => 'required|in:OK,Reject',
            'description' => 'nullable|string'
        ]);

        $result = $this->qcService->processManualQc($data);

        if ($result['status'] === 'success') {
            return redirect()->route('qc.history')->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message'])->withInput();
        }
    }
}
