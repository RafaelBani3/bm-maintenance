<?php

namespace App\Http\Controllers;

use App\Models\Cases;
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


}
