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

    public function PageDashboard(){
                
        $cases = Cases::with([
            'creator',
            'workOrder.materialRequest'
        ])->get();

        return view('content.dashboard.Dashboard', compact('cases'));
    }

    // Controller Case
    // Controller untuk tampil total data + Persen Perbandingan + Grafik    
    public function caseSummary()
    {
        $userId = Auth::id();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth = $now->copy()->subMonth()->endOfMonth();

        $totalCases = Cases::where('CR_BY', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $totalCasesLastMonth = Cases::where('CR_BY', $userId)
            ->whereBetween('created_at', [$startLastMonth, $endLastMonth])
            ->count();

        $caseByCategory = DB::table('cats')
            ->leftJoin('cases', function($join) use ($userId, $startOfMonth, $endOfMonth) {
                $join->on('cats.Cat_No', '=', 'cases.Cat_No')
                    ->where('cases.CR_BY', '=', $userId)
                    ->whereBetween('cases.created_at', [$startOfMonth, $endOfMonth]);
            })
            ->select('cats.Cat_Name', DB::raw('count(cases.Case_No) as total'))
            ->groupBy('cats.Cat_Name')
            ->get();

        return response()->json([
            'totalCases' => $totalCases,
            'totalCasesLastMonth' => $totalCasesLastMonth,
            'categories' => $caseByCategory,
        ]);
    }

    // Controller WO
        // Controller Yang bisa Persenan + Grafik
    // public function GetWOSummary()
    // {
    //     $userId = Auth::id();

    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();

    //     $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
    //     $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

    //     $woQueryThisMonth = WorkOrder::where('CR_BY', $userId)
    //         ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth]);

    //     $totalWO = $woQueryThisMonth->count();
    //     $submitCount = (clone $woQueryThisMonth)->where('WO_Status', 'REJECT')->count();
    //     $inprogressCount = (clone $woQueryThisMonth)->where('WO_Status', 'INPROGRESS')->count();
    //     $completedCount = (clone $woQueryThisMonth)->where('WO_Status', 'DONE')->count();

    //     $lastMonthTotal = WorkOrder::where('CR_BY', $userId)
    //         ->whereBetween('CR_DT', [$startOfLastMonth, $endOfLastMonth])
    //         ->count();

    //     return response()->json([
    //         'total' => $totalWO,
    //         'submitCount' => $submitCount,
    //         'inprogressCount' => $inprogressCount,
    //         'completedCount' => $completedCount,
    //         'lastMonthTotal' => $lastMonthTotal,
    //     ]);
    // }
    public function GetWOSummary()
    {
        $userId = Auth::id();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalWO = WorkOrder::where('CR_BY', $userId)
            ->whereBetween('CR_DT', [$startOfMonth, $endOfMonth])
            ->count();

        return response()->json([
            'total' => $totalWO,
        ]);
    }

    // Controller MR
    // Controller untuk tampil data, Persenan perbandingan, Grafik
        // public function getMRSummary(Request $request)
        // {
        //     $userId = Auth::id();

        //     $now = now();
        //     $thisMonthStart = $now->copy()->startOfMonth();
        //     $thisMonthEnd = $now->copy()->endOfMonth();
        //     $lastMonthStart = $now->copy()->subMonth()->startOfMonth();
        //     $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        //     $queryThisMonth = MatReq::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
        //         ->where('CR_BY', $userId);

        //     $total = $queryThisMonth->count();
        //     $submitted = (clone $queryThisMonth)->where('MR_Status', 'REJECT')->count();
        //     $inProgress = (clone $queryThisMonth)->where('MR_Status', 'INPROGRESS')->count();
        //     $done = (clone $queryThisMonth)->where('MR_Status', 'DONE')->count();

        //     $totalLastMonth = MatReq::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])
        //         ->where('CR_BY', $userId)
        //         ->count();

        //     return response()->json([
        //         'total' => $total,
        //         'submitted' => $submitted,
        //         'inProgress' => $inProgress,
        //         'done' => $done,
        //         'totalLastMonth' => $totalLastMonth,
        //     ]);
        // }

    // Controller MR untuk Tampil data MR 
    public function getMRSummary(Request $request)
    {
        $userId = Auth::id();

        $thisMonthStart = now()->startOfMonth();
        $thisMonthEnd = now()->endOfMonth();

        $total = MatReq::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])
            ->where('CR_BY', $userId)
            ->count();

        return response()->json([
            'total' => $total,
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

            $woCount = DB::table('work_orders')
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
            ->whereNotIn('MR_Status', ['DONE', 'CLOSE', 'REJECT'])
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
            ->whereNotIn('WO_Status', ['DONE', 'CLOSE']) 
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


    



}

