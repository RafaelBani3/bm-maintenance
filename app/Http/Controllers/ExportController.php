<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\MatReq;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use App\Models\CaseModel;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ExportController extends Controller
{
    // Export CASE
    public function exportCase(Request $request)
    {
        try {
            $query = Cases::query();

            $title_status = 'ALL';
            $title_search = 'ALL';

            if ($request->has('status') && $request->status !== 'all') {
                $query->where('Case_Status', $request->status);
                $title_status = strtoupper($request->status);
            }

            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('Case_No', 'like', '%' . $request->search . '%')
                        ->orWhere('Case_Name', 'like', '%' . $request->search . '%')
                        ->orWhere('Category', 'like', '%' . $request->search . '%')
                        ->orWhere('User', 'like', '%' . $request->search . '%');
                });
                $title_search = $request->search;
            }

            // $cases = $query->orderBy('Case_Date', 'desc')->get();
            $cases = $query->with(['Category', 'User.position'])->orderBy('Case_Date', 'desc')->get();


            // SPREADSHEET SETUP
            $title = 'Case Export List';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($title);
            $sheet->setShowGridlines(false);
            $sheet->getSheetView()->setZoomScale(90);

            // Judul atas
            $sheet->setCellValue('B1', "Filter Status : " . $title_status);
            $sheet->setCellValue('B2', 'Search Keyword : ' . $title_search);
            $sheet->setCellValue('B3', 'Data List - Case Report');
            $sheet->mergeCells('B1:H1');
            $sheet->mergeCells('B2:H2');
            $sheet->mergeCells('B3:H3');
            $sheet->getStyle('B1:B3')->getFont()->setBold(true);

            // HEADER TABEL
            $headers = ['Case ID', 'Case Date', 'Case Name', 'Category', 'Created By', 'Position', 'Status'];
            $colStart = 'B';
            $rowStart = 5;
            $col = $colStart;

            foreach ($headers as $header) {
                $sheet->setCellValue($col . $rowStart, $header);
                $col++;
            }

            $sheet->getRowDimension($rowStart)->setRowHeight(25);
            $sheet->freezePane('B6');
            $cell_header = 'B5:H5';
            $sheet->getStyle($cell_header)->getAlignment()->setWrapText(true);
            $sheet->getStyle($cell_header)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cell_header)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setAutoFilter($cell_header);
            $sheet->getStyle($cell_header)->getFont()->setBold(true);
            $sheet->getStyle($cell_header)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Styling header fill
            $styleHeader = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E1E5EC']
                ]
            ];
            $sheet->getStyle($cell_header)->applyFromArray($styleHeader);

            // ISI DATA
            $row = 6;
            foreach ($cases as $case) {
                $sheet->setCellValue("B$row", $case->Case_No);
                $sheet->setCellValue("C$row", date('d/m/Y', strtotime($case->Case_Date)));
                $sheet->setCellValue("D$row", $case->Case_Name);
                $sheet->setCellValue("E$row", $case->Category->Cat_Name ?? '-');
                $sheet->setCellValue("F$row", $case->User->Fullname ?? '-');
                $sheet->setCellValue("G$row", $case->User->position->PS_Name ?? '-');
                $sheet->setCellValue("H$row", $case->Case_Status);
                $row++;
            }

            // STYLE TABEL
            $range = 'B5:H' . ($row - 1);
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $sheet->getStyle($range)->applyFromArray([
                'font' => ['size' => 9]
            ]);

            $colWidths = [
                'B' => 18,
                'C' => 15,
                'D' => 30,
                'E' => 20,
                'F' => 20,
                'G' => 20,
                'H' => 15,
            ];

            foreach ($colWidths as $col => $width) {
                $sheet->getColumnDimension($col)->setWidth($width);
            }

            // EXPORT FILE
            $filename = 'case_export_' . date('Ymd_His') . '.xlsx';
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            ob_end_clean();
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            exit("Export failed: " . $e->getMessage());
        }
    }

    // EXPORT WO
    public function exportWO(Request $request)
    {
        try {
            $query = WorkOrder::query();

            $title_status = 'ALL';
            $title_search = 'ALL';

            if ($request->has('status') && $request->status !== 'all') {
                $query->where('WO_Status', $request->status);
                $title_status = strtoupper($request->status);
            }

            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('WO_No', 'like', '%' . $request->search . '%')
                        ->orWhere('WO_Name', 'like', '%' . $request->search . '%')
                        ->orWhere('Case_No', 'like', '%' . $request->search . '%');
                });
                $title_search = $request->search;
            }

            $workOrders = $query->with(['User', 'CompletedBy'])->orderBy('CR_DT', 'desc')->get();

            // Spreadsheet SETUP
            $title = 'Work Order Export List';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($title);
            $sheet->setShowGridlines(false);
            $sheet->getSheetView()->setZoomScale(90);

            // Title Atas
            $sheet->setCellValue('B1', "Filter Status : " . $title_status);
            $sheet->setCellValue('B2', "Search Keyword : " . $title_search);
            $sheet->setCellValue('B3', "Data List - Work Order Report");
            $sheet->mergeCells('B1:H1');
            $sheet->mergeCells('B2:H2');
            $sheet->mergeCells('B3:H3');
            $sheet->getStyle('B1:B3')->getFont()->setBold(true);

            // Header Table
            $headers = ['WO No', 'Case No', 'Requested By', 'Created Date',
                'WO Start', 'WO End', 'Status', 'Narrative',
                'Need Material', 'Completed Date', 'Completed By', 'Technicians'];

            $colStart = 'B';
            $rowStart = 5;
            $col = $colStart;

            foreach ($headers as $header) {
                $sheet->setCellValue($col . $rowStart, $header);
                $col++;
            }

            $sheet->getRowDimension($rowStart)->setRowHeight(25);
            $sheet->freezePane('B6');
            $cell_header = 'B5:M5';
            $sheet->getStyle($cell_header)->getAlignment()->setWrapText(true);
            $sheet->getStyle($cell_header)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cell_header)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setAutoFilter($cell_header);
            $sheet->getStyle($cell_header)->getFont()->setBold(true);
            $sheet->getStyle($cell_header)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Styling header fill
            $styleHeader = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E1E5EC']
                ]
            ];
            $sheet->getStyle($cell_header)->applyFromArray($styleHeader);

            // ISI DATA
            $row = 6;
            foreach ($workOrders as $wo) {
                    $technicians = DB::table('WO_DoneBy')
                    ->join('technician', 'WO_DoneBy.technician_id', '=', 'technician.technician_id')
                    ->where('WO_DoneBy.WO_No', $wo->WO_No)
                    ->pluck('technician.technician_Name')
                    ->implode(', ');

                $sheet->setCellValue("B$row", $wo->WO_No);
                $sheet->setCellValue("C$row", $wo->Case_No);
                $sheet->setCellValue("D$row", $wo->User->Fullname ?? '-');
                $sheet->setCellValue("E$row", $wo->CR_DT ? date('d/m/Y', strtotime($wo->CR_DT)) : '-');
                $sheet->setCellValue("F$row", $wo->WO_Start ? date('d/m/Y', strtotime($wo->WO_Start)) : '-');
                $sheet->setCellValue("G$row", $wo->WO_End ? date('d/m/Y', strtotime($wo->WO_End)) : '-');
                $sheet->setCellValue("H$row", $wo->WO_Status);
                $sheet->setCellValue("I$row", $wo->WO_Narative);
                $sheet->setCellValue("J$row", $wo->WO_NeedMat == 'Y' ? 'Yes' : 'No');
                $sheet->setCellValue("K$row", $wo->WO_CompDate ? date('d/m/Y', strtotime($wo->WO_CompletedDate)) : '-');
                $sheet->setCellValue("L$row", $wo->CompletedBy->Fullname ?? '-');
                $sheet->setCellValue("M$row", $technicians ?: '-');

                $row++;
            }

            // STYLE TABEL
            $range = 'B5:M' . ($row - 1);
            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($range)->applyFromArray(['font' => ['size' => 9]]);

            $colWidths = [
                'B' => 15,
                'C' => 15,
                'D' => 20,
                'E' => 15,
                'F' => 15,
                'G' => 15,
                'H' => 15,
                'I' => 30,
                'J' => 15,
                'K' => 15,
                'L' => 20,
                'M' => 30,
            ];

            foreach ($colWidths as $col => $width) {
                $sheet->getColumnDimension($col)->setWidth($width);
            }

            // EXPORT FILE
            $filename = 'workorder_export_' . date('Ymd_His') . '.xlsx';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment;filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            ob_end_clean();
            $writer->save('php://output');
            exit;
        } catch (\Exception $e) {
            exit("Export failed: " . $e->getMessage());
        }
    }

    // EXPORT MR
    public function exportMR(Request $request)
    {
        try{

            $query = MatReq::query();

            $title_status = 'ALL';
            $title_search = 'ALL';

            if ($request->has('status') && $request->status !== 'all') {
                $query->where('MR_Status', $request->status);
                $title_status = strtoupper($request->status);
            }

            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('MR_No', 'like', '%' . $request->search . '%')
                        ->orWhere('Case_No', 'like', '%' . $request->search . '%')
                        ->orWhere('WO_No', 'like', '%' . $request->search . '%');
                });
                $title_search = $request->search;
            }

            $MatReq = $query->with(['createdBy','children'])->orderBy('CR_DT', 'desc')->get();

            // Spreadsheet SETUP
            $title = 'Work Order Export List';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($title);
            $sheet->setShowGridlines(false);
            $sheet->getSheetView()->setZoomScale(90);

            // Title Atas
            $sheet->setCellValue('B1', "Filter Status : " . $title_status);
            $sheet->setCellValue('B2', "Search Keyword : " . $title_search);
            $sheet->setCellValue('B3', "Data List - Material Request Report");
            $sheet->mergeCells('B1:H1');
            $sheet->mergeCells('B2:H2');
            $sheet->mergeCells('B3:H3');
            $sheet->getStyle('B1:B3')->getFont()->setBold(true);
            
            // Header Table
            $headers = ['MR_No','WO No', 'Case No','Created Date', 'Status', 'Item Code',
                        'Item Name','Qty','Description','Timestamp'];

            $colStart = 'B';
            $rowStart = 5;
            $col = $colStart;
            
            foreach ($headers as $header) {
                $sheet->setCellValue($col . $rowStart, $header);
                $col++;
            }

            $sheet->getRowDimension($rowStart)->setRowHeight(25);
            $sheet->freezePane('B6');
            $cell_header = 'B5:M5';
            $sheet->getStyle($cell_header)->getAlignment()->setWrapText(true);
            $sheet->getStyle($cell_header)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cell_header)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setAutoFilter($cell_header);
            $sheet->getStyle($cell_header)->getFont()->setBold(true);
            $sheet->getStyle($cell_header)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Styling header fill
            $styleHeader = [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E1E5EC']
                ]
            ];
            $sheet->getStyle($cell_header)->applyFromArray($styleHeader);

            $row = $rowStart + 1;

            foreach ($MatReq as $mr) {
                $childCount = $mr->children->count();
                $startRow = $row;
                $endRow = $row + $childCount - 1;

                foreach ($mr->children as $child) {
                    $sheet->setCellValue('G' . $row, $child->Item_Code);
                    $sheet->setCellValue('H' . $row, $child->Item_Name);
                    $sheet->setCellValue('I' . $row, $child->Item_Oty);
                    $sheet->setCellValue('J' . $row, $child->Remark);
                    $sheet->setCellValue('K' . $row, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($mr->CR_DT));
                    $sheet->getStyle('K' . $row)->getNumberFormat()
                        ->setFormatCode('yyyy-mm-dd hh:mm:ss');

                    $row++;
                }

                $sheet->mergeCells("B{$startRow}:B{$endRow}");
                $sheet->mergeCells("C{$startRow}:C{$endRow}");
                $sheet->mergeCells("D{$startRow}:D{$endRow}");
                $sheet->mergeCells("E{$startRow}:E{$endRow}");
                $sheet->mergeCells("F{$startRow}:F{$endRow}");

                $sheet->setCellValue("B{$startRow}", $mr->MR_No);
                $sheet->setCellValue("C{$startRow}", $mr->WO_No);
                $sheet->setCellValue("D{$startRow}", $mr->Case_No);
                $sheet->setCellValue("E{$startRow}", \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($mr->MR_Date));
                $sheet->getStyle("E{$startRow}")->getNumberFormat()
                    ->setFormatCode('yyyy-mm-dd hh:mm:ss');
                $sheet->setCellValue("F{$startRow}", $mr->MR_Status);
            }

            foreach (range('B', 'K') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'MaterialRequest_Export_' . now()->format('Ymd_His') . '.xlsx';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            ob_end_clean();
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            exit("Export failed: " . $e->getMessage());
        }
    }


    public function exportWOC(Request $request)
    {
        try {
            $query = WorkOrder::query();

            $title_status = 'ALL';
            $title_search = 'ALL';

            if ($request->has('status') && $request->status !== 'all') {
                $query->where('WOC_Status', $request->status); 
                $title_status = strtoupper($request->status);
            }

            if ($request->has('search') && $request->search != '') {
                $query->where(function ($q) use ($request) {
                    $q->where('WOC_No', 'like', '%' . $request->search . '%')
                    ->orWhere('WO_No', 'like', '%' . $request->search . '%')
                    ->orWhere('Case_Name', 'like', '%' . $request->search . '%');
                });
                $title_search = $request->search;
            }

            $workOrders = $query->with(['createdBy'])->orderBy('created_at', 'desc')->get();

            $title = 'WOC Export List';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle($title);
            $sheet->setShowGridlines(false);
            $sheet->getSheetView()->setZoomScale(90);

            // Filter info
            $sheet->setCellValue('B1', "Filter Status : " . $title_status);
            $sheet->setCellValue('B2', "Search Keyword : " . $title_search);
            $sheet->setCellValue('B3', "Data List - Work Order Completion Report");
            $sheet->mergeCells('B1:I1');
            $sheet->mergeCells('B2:I2');
            $sheet->mergeCells('B3:I3');
            $sheet->getStyle('B1:B3')->getFont()->setBold(true);

            // Header table
            $headers = ['WOC No', 'WO No', 'Case Name', 'Created By', 'Position', 'Complete Date', 'Completed By', 'Status'];
            $colStart = 'B';
            $rowStart = 5;
            $col = $colStart;

            foreach ($headers as $header) {
                $sheet->setCellValue($col . $rowStart, $header);
                $col++;
            }

            $sheet->getRowDimension($rowStart)->setRowHeight(25);
            $sheet->freezePane('B6');
            $cell_header = 'B5:I5';
            $sheet->getStyle($cell_header)->getAlignment()->setWrapText(true);
            $sheet->getStyle($cell_header)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($cell_header)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setAutoFilter($cell_header);
            $sheet->getStyle($cell_header)->getFont()->setBold(true);
            $sheet->getStyle($cell_header)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $sheet->getStyle($cell_header)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E1E5EC']
                ]
            ]);

            $row = $rowStart + 1;

            foreach ($workOrders as $wo) {
                $sheet->setCellValue('B' . $row, $wo->WOC_No);
                $sheet->setCellValue('C' . $row, $wo->WO_No);
                $sheet->setCellValue('D' . $row, $wo->case->Case_Name);
                $sheet->setCellValue('E' . $row, $wo->createdBy->Fullname ?? '-');
                $sheet->setCellValue('F' . $row, $wo->createdBy->position->PS_Name ?? '-');
                
                if ($wo->WO_CompDate) {
                    $sheet->setCellValue('G' . $row, date('d/m/Y', strtotime($wo->WO_CompDate)));
                } else {
                    $sheet->setCellValue('G' . $row, '-');
                }

                $sheet->setCellValue('H' . $row, $wo->User->Fullname ?? '-');
                $sheet->setCellValue('I' . $row, $wo->WO_Status);

                $row++;
            }

            foreach (range('B', 'I') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $filename = 'WorkOrderCompletion_Export_' . now()->format('Ymd_His') . '.xlsx';
            $writer = new Xlsx($spreadsheet);

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            ob_end_clean();
            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            exit("Export failed: " . $e->getMessage());
        }
    }



}

