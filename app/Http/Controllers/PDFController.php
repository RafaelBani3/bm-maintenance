<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\MatReq;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function exportPDF($encodedCaseNo)
    {
        try {
            $caseNo = base64_decode($encodedCaseNo);
            $case = Cases::where('Case_No', $caseNo)->firstOrFail();

            $pdf = Pdf::loadView('content.case.pdf.casepdf', compact('case'));
            $fileName = 'Case_' . str_replace('/', '-', $case->Case_No) . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function exportMRPDF($encoded)
    {
        try {
            $mrNo = base64_decode($encoded);
            $mr = MatReq::where('MR_No', $mrNo)->firstOrFail();

            $pdf = Pdf::loadView('content.mr.pdf.mrpdf', compact('mr'));
            $fileName = 'MaterialRequest_' . str_replace('/', '-', $mr->MR_No) . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }   

    public function exportWOCPDF($encodedWONo){
        try {
            $woNo = base64_decode($encodedWONo);

            $wo = WorkOrder::with('technicians_woc')->where('WO_No', $woNo)->firstOrFail();

            $pdf = Pdf::loadView('content.woc.pdf.wocpdf', compact('wo'));
            $fileName = 'Workorder_Completion' . str_replace('/', '-', $wo->WOC_No) . '.pdf';

            return $pdf->download($fileName);

        } catch (\Exception $e){
            return redirect()->back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }






}
