<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\MatReq;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    // public function PageDashboard(){
                
    //     $cases = Cases::with([
    //         'creator',
    //         'workOrder.materialRequest'
    //     ])->get();

    //     return view('content.dashboard.Dashboard', compact('cases'));
    // }


    public function PageDashboard(Request $request) {
        $userId = Auth::id();
        $now = Carbon::now();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Batasi agar tidak bisa lihat bulan di masa depan
        if ($year > now()->year || ($year == now()->year && $month > now()->month)) {
            abort(403, 'Data bulan tersebut tidak tersedia.');
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $cases = Cases::with(['creator', 'workOrder.materialRequest'])
            ->where('CR_BY', $userId)
            // ->whereBetween('created_at', [$startOfMonth, $endOfMonth]) 
            ->paginate(5);

        $totalApproved = Cases::where('CR_BY', $userId)
            ->whereIn('Case_Status', ['AP2'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalRejected = Cases::where('CR_BY', $userId)
            ->where('Case_Status', 'REJECT')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalWOtoMR = WorkOrder::where('WO_MR', $userId)
            ->where('WO_NeedMat', 'Y') 
            ->whereIn('WO_Status', ['SUBMIT']) 
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalWOtoWOC = WorkOrder::whereNull('WO_MR')
            ->where('CR_BY', $userId)
            ->where('WO_NeedMat', 'N')
            ->where('WO_IsComplete', 'N')
            ->whereNull('WO_CompDate') 
            ->whereIn('WO_Status', ['INPROGRESS'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // $TotalMRapproved = MatReq::where('MR_Status', 'AP4')
        //     ->where('CR_BY', $userId)
        //     ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
        //     ->count();

        $TotalMRapproved = MatReq::where('MR_Status', 'AP4')
            ->whereHas('workOrder', function ($q) use ($userId) {
                $q->where('CR_BY', $userId);
            })
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $TotalMRrejected = MatReq::where('MR_Status', 'REJECT')
            ->where('CR_BY', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $rejectedWoc = WorkOrder::where('CR_BY', $userId)
            ->where('WO_Status', 'REJECT_COMPLETION')
            ->whereNotNull('WOC_No')
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        $doneWoc = WorkOrder::where('CR_BY', $userId)
            ->where('WO_Status', 'DONE')
            ->whereNotNull('WOC_No')
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        return view('content.dashboard.Dashboard', compact(
  'cases', 
 'totalApproved', 
            'totalRejected',
            'totalWOtoMR',
            'TotalMRapproved',
            'TotalMRrejected',
            'rejectedWoc',
            'doneWoc',
            'totalWOtoWOC'
        ));
    }

    public function trackCase(Request $request)
    {
        $encodedCaseNo = $request->query('case');

        if (!$encodedCaseNo) {
            return response()->json(['error' => 'Case number not provided'], 400);
        }

        $caseNo = base64_decode($encodedCaseNo); 
        
        $case = Cases::with([
            'workOrder.materialRequest'
        ])->where('Case_No', $caseNo)->first();

        if (!$case) {
            return response()->json(['error' => 'Case not found'], 404);
        }

        // Logic untuk menentukan tracking step
        $step = 1;
        $skipMatReq = false;

        if (in_array($case->Case_Status, ['AP2', 'INPROGRESS'])) {
            $step = 2;
        }

        $wo = $case->workOrder;
        if ($wo) {
            $step = 3;
            if ($wo->WO_NeedMat === 'Y') {
                $step = 4;
                if ($wo->materialRequest && in_array($wo->materialRequest->MR_Status, ['AP4', 'DONE', 'CLOSE'])) {
                    $step = 5;
                }
            } else {
                $skipMatReq = true;
            }

            if ($wo->WO_Status === 'SUBMIT_COMPLETION') {
                $step = 6;
            }

            if ($wo->WO_Status === 'DONE') {
                $step = 7;
            }

            if ($wo->WO_Status === 'DONE') {
                $step = 8;
            }
        }

        return response()->json([
            'step' => $step,
            'skip_mat_req' => $skipMatReq
        ]);
    }


    public function getWaitingCounts()
    {
        $userId = Auth::id(); // ambil ID user yang login

        // Hitung total case dengan status AP2 milik user yang login
        $total_case_ap2 = DB::table('cases')
            ->where('Case_Status', 'AP2')
            ->where('CR_BY', $userId)
            ->count();

        // Hitung total material request dengan status AP4 atau DONE milik user yang login
        $total_mr_ap4 = DB::table('Mat_Req')
            ->whereIn('MR_Status', ['AP4', 'DONE'])
            ->where('CR_BY', $userId)
            ->count();

        return response()->json([
            'total_case_ap2' => $total_case_ap2,
            'total_mr_ap4' => $total_mr_ap4,
        ]);
    }


    // Controller Case : Total Case & Chart Total Case By Category
    // public function caseSummary()
    // {
    //     $userId = Auth::id();
    //     $now = Carbon::now();
    //     $startOfMonth = $now->copy()->startOfMonth();
    //     $endOfMonth = $now->copy()->endOfMonth();

    //     $startLastMonth = $now->copy()->subMonth()->startOfMonth();
    //     $endLastMonth = $now->copy()->subMonth()->endOfMonth();

    //     $totalCases = Cases::where('CR_BY', $userId)
    //         ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    //         ->count();

    //     $caseByCategory = DB::table('Cats')
    //         ->leftJoin('cases', function($join) use ($userId, $startOfMonth, $endOfMonth) {
    //             $join->on('Cats.Cat_No', '=', 'cases.Cat_No')
    //                 ->where('cases.CR_BY', '=', $userId)
    //                 ->whereBetween('cases.created_at', [$startOfMonth, $endOfMonth]);
    //         })
    //         ->select('Cats.Cat_Name', DB::raw('count(cases.Case_No) as total'))
    //         ->groupBy('Cats.Cat_Name')
    //         ->get();

    //     return response()->json([
    //         'totalCases' => $totalCases,
    //         'categories' => $caseByCategory,
    //     ]);
    // }
    
    public function caseSummary(Request $request)
    {
        $userId = Auth::id();
        $now = Carbon::now();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Batasi agar tidak bisa lihat bulan di masa depan
        if ($year > now()->year || ($year == now()->year && $month > now()->month)) {
            abort(403, 'Data bulan tersebut tidak tersedia.');
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $totalCases = Cases::where('CR_BY', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalApproved = Cases::where('CR_BY', $userId)
            ->where('Case_Status', ['AP2'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalRejected = Cases::where('CR_BY', $userId)
            ->where('Case_Status', 'REJECT')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $caseByCategory = DB::table('Cats')
            ->leftJoin('cases', function($join) use ($userId, $startOfMonth, $endOfMonth) {
                $join->on('Cats.Cat_No', '=', 'cases.Cat_No')
                    ->where('cases.CR_BY', '=', $userId)
                    ->whereBetween('cases.created_at', [$startOfMonth, $endOfMonth]);
            })
            ->select('Cats.Cat_Name', DB::raw('count(cases.Case_No) as total'))
            ->groupBy('Cats.Cat_Name')
            ->get();

        return response()->json([
            'totalCases' => $totalCases,
            'totalApproved' => $totalApproved,
            'totalRejected' => $totalRejected,
            'categories' => $caseByCategory,
        ]);
    }


    // // Controller WO
    public function GetWOSummary(Request $request)
    {
        $userId = Auth::id();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        if ($year > now()->year || ($year == now()->year && $month > now()->month)) {
            abort(403, 'Data bulan tersebut tidak tersedia.');
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $totalWO = WorkOrder::where('CR_BY', $userId)
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        // $inprogress = WorkOrder::where('CR_BY', $userId)
        //     ->where('WO_Status', ['SUBMIT','INPROGRESS'])
        //     ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
        //     ->count();

        $inprogress = WorkOrder::where(function ($query) use ($userId) {
        $query->where('CR_BY', $userId)
                ->orWhere('WO_MR', $userId);
        })
        ->whereIn('WO_Status', ['SUBMIT', 'INPROGRESS'])
        ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
        ->count();

        $done = WorkOrder::where('CR_BY', $userId)
            ->where('WO_Status', 'DONE')
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        return response()->json([
            'total' => $totalWO,
            'inprogress' => $inprogress,
            'done' => $done,
        ]);
    }

    
    // Controller MR
    public function getMRSummary(Request $request)
    {
        $userId = Auth::id();
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Batasi agar tidak bisa lihat bulan di masa depan
        if ($year > now()->year || ($year == now()->year && $month > now()->month)) {
            abort(403, 'Data bulan tersebut tidak tersedia.');
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $total = MatReq::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('CR_BY', $userId)
            ->count();

        $approved = MatReq::where('MR_Status', 'AP4')
            ->where('CR_BY', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $rejected = MatReq::where('MR_Status', 'REJECT')
            ->where('CR_BY', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        return response()->json([
            'total' => $total,
            'approved' => $approved,
            'rejected' => $rejected,
        ]);
    }


    public function GetWOCSummary(Request $request)
    {
        $userId = Auth::id();

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        // Batasi agar tidak bisa lihat bulan di masa depan
        if ($year > now()->year || ($year == now()->year && $month > now()->month)) {
            abort(403, 'Data bulan tersebut tidak tersedia.');
        }

        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();


        $totalWOC = WorkOrder::where('CR_BY', $userId)
            ->where('WO_IsComplete', 'Y') 
            ->whereNotNull('WOC_No')
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        $rejectedWoc = WorkOrder::where('CR_BY', $userId)
            ->where('WO_Status', 'REJECT_COMPLETION')
            ->whereNotNull('WOC_No')
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        $doneWoc = WorkOrder::where('CR_BY', $userId)
            ->where('WO_Status', 'DONE')
            ->whereNotNull('WOC_No')
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        return response()->json([
            'total' => $totalWOC,
            'rejectedWoc' => $rejectedWoc,
            'doneWoc' => $doneWoc,
        ]);
    }
    
    public function getCaseWOSummary()
    {
        $userId = Auth::id();
        $months = [];
        $caseData = [];
        $woData = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->format('M');

            $caseCount = DB::table('cases')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->where('CR_BY', $userId)
                ->count();

            $woCount = DB::table('Work_Orders')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->where('CR_BY', $userId)
                ->count();

            $months[] = $monthName;
            $caseData[] = $caseCount;
            $woData[] = $woCount;
        }

        return response()->json([
            'months' => $months,
            'caseData' => $caseData,
            'woData' => $woData,
        ]);
    }

// DASHBOARD APPROVER
    public function getCaseApprovalProgress()
    {
        $userId = Auth::id();
        $userStep = null;
        $currentStatus = null;
        $nextStatus = null;

        $isApprover1 = DB::table('cases')
            ->where('Case_AP1', $userId)
            ->where('Case_ApStep', 1)
            ->where('Case_Status', 'SUBMIT')
            ->exists();

        if ($isApprover1) {
            $userStep = 1;
            $currentStatus = 'SUBMIT';
            $nextStatus = 'AP1';
        }

        if (!$userStep) {
            $isApprover2 = DB::table('cases')
                ->where('Case_AP2', $userId)
                ->where('Case_ApStep', 2)
                ->where('Case_Status', 'AP1')
                ->exists();

            if ($isApprover2) {
                $userStep = 2;
                $currentStatus = 'AP1';
                $nextStatus = 'AP2';
            }
        }

        if (!$userStep) {
            return response()->json([
                'step' => null,
                'total' => 0,
                'approved' => 0,
                'pending' => 0,
                'percentage' => 0
            ]);
        }

        $pendingCount = DB::table('cases')
            ->where("Case_AP{$userStep}", $userId)
            ->where('Case_ApStep', $userStep)
            ->where('Case_Status', $currentStatus)
            ->count();

        $approvedCount = DB::table('cases')
            ->where("Case_AP{$userStep}", $userId)
            ->where('Case_ApStep', '>=', $userStep)
            ->where('Case_Status', $nextStatus)
            ->count();

        $totalAssigned = $pendingCount + $approvedCount;
        $percentage = $totalAssigned > 0 ? round(($approvedCount / $totalAssigned) * 100, 1) : 0;

        return response()->json([
            'step' => $userStep,
            'total' => $totalAssigned,
            'approved' => $approvedCount,
            'pending' => $pendingCount,
            'percentage' => $percentage
        ]);
    }

    public function getPendingMRCount()
    {
        $userId = Auth::id();

        $totalPendingMR = DB::table('Mat_Req')
            ->where(function ($query) use ($userId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('MR_APStep', 1)->where('MR_AP1', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('MR_APStep', 2)->where('MR_AP2', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('MR_APStep', 3)->where('MR_AP3', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('MR_APStep', 4)->where('MR_AP4', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('MR_APStep', 5)->where('MR_AP5', $userId);
                });
            })
            ->whereNotIn('MR_Status', ['DONE', 'CLOSE', 'REJECT','AP4'])
            ->count();

        return response()->json(['count' => $totalPendingMR]);
    }

    public function getPendingWOCCount()
    {
        $userId = Auth::id();

        $pendingWOC = DB::table('Work_Orders')
            ->where('WO_IsComplete', 'Y') 
            ->where(function ($query) use ($userId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('WO_APStep', 1)->where('WO_AP1', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('WO_APStep', 2)->where('WO_AP2', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('WO_APStep', 3)->where('WO_AP3', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('WO_APStep', 4)->where('WO_AP4', $userId);
                })->orWhere(function ($q) use ($userId) {
                    $q->where('WO_APStep', 5)->where('WO_AP5', $userId);
                });
            }) 
            ->whereNotIn('WO_Status', ['DONE', 'CLOSE','REJECT','OPEN', 'OPEN_COMPLETION', 'REJECT_COMPLETION', 'INPROGRESS']) 
            ->count();

        return response()->json(['count' => $pendingWOC]);
    }

    public function showCaseTable()
    {
        $cases = Cases::with([
            'creator',
            'workOrder.materialRequest'
        ])->get();

        return view('content.dashboard.Dashboard', compact('cases'));
    }


    
    // TRACKING PAGE
    public function trackingPage(){
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $cases = Cases::with(['creator', 'workOrder.materialRequest'])                          
            ->latest()
            ->get();

        return view('content.tracking.trackingpage',compact('cases'));
    }



}


