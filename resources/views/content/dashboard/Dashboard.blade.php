@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Dashboard')

@section('content')

    <style>
        .card.card-flush {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .card.card-flush:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header .card-title {
            gap: 0.5rem;
        }

        .card-header {
            border-bottom: 1px solid #eff2f5;
            padding-bottom: 1rem;
        }

        .card-footer {
            padding-top: 1rem;
            border-top: 1px solid #eff2f5;
            background-color: #f9fbfd;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e4e6ef;
        }

        .progress-bar {
            border-radius: 4px;
        }

        .badge i {
            margin-right: 0.25rem;
        }

        .fs-4hx {
            font-size: 2.75rem;
        }

        @media (max-width: 768px) {
            .card-body {
                text-align: center;
            }
        }

        .hover-scale:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
            cursor: pointer;
        }

        .step-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
        }

        .border-primary {
            border-color: #0d6efd !important; /* Bootstrap Primary */
        }

        .bg-primary {
            background-color: #0d6efd !important;
        }

        .text-white {
            color: white !important;
        }
        
    </style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


             
    <!--begin::Dashboard Creator-->
    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo', 'view mr']))
        
        <!-- Main Content -->       
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!-- Row 1: Summary Cards -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <!-- Total Cases -->
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="text-gray-800 fw-bold mb-0">Total Cases</h4>
                                    <span class="badge badge-light-primary">This Month</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2" id="total-case">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Work Orders -->
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="text-gray-800 fw-bold mb-0">Total Work Orders</h4>
                                    <span class="badge badge-light-info">This Month</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2" id="wo-total">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Material Requests -->
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="text-gray-800 fw-bold mb-0">Total Material Requests</h4>
                                    <span class="badge badge-light-danger">This Month</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-2hx fw-bold text-dark me-2" id="mr-total">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: table -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <div class="col-md-12">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Case No</th>
                                            <th>Case Name</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cases as $case)
                                        @php
                                            $safeCaseNo = str_replace(['/', ' '], ['-', '_'], $case['Case_No']);
                                        @endphp
                                        <tr>
                                            <td>{{ $case['Case_No'] }}</td>
                                            <td>{{ $case['Case_Name'] }}</td>
                                            <td>{{ $case['Case_Status'] }}</td>
                                            <td>
                                                <button data-bs-toggle="modal" data-bs-target="#modalProgress{{ $safeCaseNo }}">
                                                    Lihat Progress
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Charts -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <!-- Case by Category Chart -->
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="text-muted fw-semibold mb-0">Cases by Category (Monthly)</h5>
                                    <div id="case-change"></div>
                                </div>
                                <div id="kt_docs_google_chart_column" style="height: 200px;"></div>
                                <div class="mt-4" id="category-list"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Case vs Work Order Chart -->
                    <div class="col-md-8">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="text-muted fw-semibold mb-0">Monthly Case vs Work Order</h5>
                                </div>
                                <div id="kt_apexcharts_1" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--end::Content-->
    @endif


    <!-- MODAL PROGRESS -->
    @foreach($cases as $case)
    @php
        $safeCaseNo = str_replace(['/', ' '], ['-', '_'], $case['Case_No']);
    @endphp
        <!-- Modal -->
    <div class="modal fade" id="modalProgress{{ $safeCaseNo }}" tabindex="-1" aria-labelledby="modalLabel{{ $safeCaseNo }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $case['Case_No'] }}">Progress Case {{ $case['Case_No'] }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="d-flex align-items-center justify-content-between px-2">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="step-icon rounded-circle border @if($case['step'] >= 1) bg-primary text-white @else bg-light @endif" style="width: 40px; height: 40px; line-height: 40px;">
                    ✓
                    </div>
                    <small class="d-block mt-1">Case Approved</small>
                    
                </div>

                <div class="flex-grow-1 border-top mx-2 @if($case['step'] >= 2) border-primary @endif"></div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="step-icon rounded-circle border @if($case['step'] >= 2) bg-primary text-white @else bg-light @endif" style="width: 40px; height: 40px; line-height: 40px;">
                    ✓
                    </div>
                    <small class="d-block mt-1">WO Created</small>
                </div>

                <div class="flex-grow-1 border-top mx-2 @if($case['step'] >= 3) border-primary @endif"></div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="step-icon rounded-circle border @if($case['step'] >= 3) bg-primary text-white @else bg-light @endif" style="width: 40px; height: 40px; line-height: 40px;">
                    ✓
                    </div>
                    <small class="d-block mt-1">MR Approved</small>
                </div>

                <div class="flex-grow-1 border-top mx-2 @if($case['step'] == 4) border-primary @endif"></div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="step-icon rounded-circle border @if($case['step'] == 4) bg-primary text-white @else bg-light @endif" style="width: 40px; height: 40px; line-height: 40px;">
                    ✓
                    </div>
                    <small class="d-block mt-1">Selesai</small>
                </div>
                </div>

            </div>
            </div>
        </div>
        </div>
        @endforeach


    {{-- Dashboard APPROVAL --}}
    @if(auth()->user()->hasAnyPermission(['view cr_ap','view mr_ap']))

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                
                <!--begin::Row: Approval Summary-->
                <div class="row gx-5 gx-xl-10 mb-10">

                    <!--begin::Card: Total Cases Created-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <a href="{{ route('ApprovalCase') }}" class="card card-flush h-md-100 flex-grow-1 text-decoration-none hover-scale" style="transition: all 0.3s;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Approval Cases</span>
                                    <span class="badge badge-light-primary fs-8">Pending Approval</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-primary me-2" id="total-case-to-approve">0</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!--begin::Card: Material Requests Awaiting Approval-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <a href="{{ route('ApprovalListMR') }}" class="card card-flush h-md-100 flex-grow-1 text-decoration-none hover-scale" style="transition: all 0.3s;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Approval Material Requests</span>
                                    <span class="badge badge-light-info fs-8">Pending Approval</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-info me-2" id="pending-mr-count">0</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!--begin::Card: Completed WOs Awaiting Approval-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <a href="{{ route('ApprovalListWOC') }}" class="card card-flush h-md-100 flex-grow-1 text-decoration-none hover-scale" style="transition: all 0.3s;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Approval WO's Completed</span>
                                    <span class="badge badge-light-success fs-8">Pending Approval</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-success me-2" id="pending-woc-count">0</span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>

                <!--begin::Row: Latest Approval Activities-->
                <div class="row gx-5 gx-xl-10">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header">
                                <h3 class="card-title">Latest Approval Activities</h3>
                            </div>
                            <div class="card-body">
                                <table class="table align-middle table-row-dashed">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th>Type</th>
                                            <th>Reference</th>
                                            <th>Status</th>
                                            <th>Approved On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Material Request</td>
                                            <td>#MR045</td>
                                            <td><span class="badge badge-light-success">Approved</span></td>
                                            <td>2025-05-26</td>
                                        </tr>
                                        <tr>
                                            <td>Work Order</td>
                                            <td>#WO031</td>
                                            <td><span class="badge badge-light-danger">Rejected</span></td>
                                            <td>2025-05-24</td>
                                        </tr>
                                        <tr>
                                            <td>Case</td>
                                            <td>#CASE008</td>
                                            <td><span class="badge badge-light-warning">Pending</span></td>
                                            <td>-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endif

    <!--Script: Dashboard Creator-->
    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo', 'view mr']))
        
    <!--Script Case Chart & Total Case-->
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                fetch("{{ route('case.summary') }}")
                    .then(response => response.json())
                    .then(data => {
                        // Tampilkan total case bulan ini
                        const total = data.totalCases ?? 0;
                        const totalCaseEl = document.getElementById("total-case");
                        if (totalCaseEl) totalCaseEl.textContent = total;

                        // Data Kategori dan Setup Warna
                        const colorList = [
                            { color: '#fe3995', class: 'bg-danger' },
                            { color: '#f6aa33', class: 'bg-warning' },
                            { color: '#6e4ff5', class: 'bg-primary' },
                            { color: '#2abe81', class: 'bg-success' },
                            { color: '#c7d2e7', class: 'bg-info' }
                        ];

                        const chartData = [['Category', 'Total Cases']];
                        const chartColors = [];
                        const categoryList = document.getElementById("category-list");
                        categoryList.innerHTML = "";

                        let isAllZero = true;

                        data.categories.forEach((cat, index) => {
                            const total = parseInt(cat.total);
                            if (total > 0) isAllZero = false;

                            const colorInfo = total > 0
                                ? colorList[index % colorList.length]
                                : { color: '#E4E6EF', class: 'bg-secondary' };

                            chartData.push([cat.Cat_Name, total]);
                            chartColors.push(colorInfo.color);

                            categoryList.innerHTML += `
                                <div class="d-flex fs-7 fw-semibold align-items-center mb-3 flex-wrap">
                                    <div class="bullet w-8px h-6px rounded-2 ${colorInfo.class} me-2"></div>
                                    <div class="text-gray-500 flex-grow-1 text-truncate">${cat.Cat_Name}</div>
                                    <div class="fw-bolder text-gray-700 text-end">${total} Case</div>
                                </div>
                            `;
                        });

                        if (isAllZero) {
                            chartData.push(['No Data', 1]);
                            chartColors.push('#E4E6EF');
                        }

                        // Load & Gambar Chart
                        google.charts.load('current', { 'packages': ['corechart'] });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            const dataTable = google.visualization.arrayToDataTable(chartData);
                            const options = {
                                backgroundColor: '#ffffff',
                                pieHole: 0.7,
                                pieSliceText: 'none',
                                legend: 'none',
                                chartArea: { width: '100%', height: '100%' },
                                colors: chartColors,
                                tooltip: {
                                    showColorCode: true,
                                    textStyle: {
                                        fontSize: 14,
                                        bold: true,
                                        color: 'black'
                                    }
                                }
                            };

                            const chart = new google.visualization.PieChart(
                                document.getElementById('kt_docs_google_chart_column')
                            );
                            chart.draw(dataTable, options);
                        }

                    })
                    .catch(err => {
                        console.error("Gagal memuat data dashboard:", err);
                    });
            });
        </script>


    <!--begin::Row: Latest Approval Activities-->
        {{-- Script WO yang Change(Persenan) dan Grafik ada  --}}
            {{-- <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function () {
                    google.charts.load("current", { packages: ["corechart"] });
                    google.charts.setOnLoadCallback(fetchAndDrawChart);

                    function fetchAndDrawChart() {
                        fetch("{{ route('dashboard.wo-summary') }}")
                            .then(response => response.json())
                            .then(data => {
                                const total = data.total || 0;
                                const lastMonthTotal = data.lastMonthTotal || 0;

                                const change = total - lastMonthTotal;
                                const percentChange = lastMonthTotal > 0
                                    ? (change / lastMonthTotal) * 100
                                    : 100;

                                const totalEl = document.getElementById("wo-total");
                                if (totalEl) totalEl.textContent = total;

                                const changeEl = document.getElementById("wo-change");
                                const changeIcon = change >= 0
                                    ? `<i class="ki-outline ki-arrow-up fs-3 text-success me-1"></i>`
                                    : `<i class="ki-outline ki-arrow-down fs-3 text-danger me-1"></i>`;
                                const changeClass = change >= 0 ? 'text-success' : 'text-danger';

                                if (changeEl) {
                                    changeEl.innerHTML = `${changeIcon}${percentChange.toFixed(1)}%`;
                                    changeEl.className = `fs-4 fw-bold d-flex align-items-center ${changeClass}`;
                                }

                                const chartData = google.visualization.arrayToDataTable([
                                    ['Status', 'Jumlah', { role: 'style' }],
                                    ['INPROGRESS', data.inprogressCount, '#ffc107'], 
                                    ['REJECT', data.submitCount, '#dc3545'],         
                                    ['DONE', data.completedCount, '#28a745']     
                                ]);

                                const options = {
                                    title: '',
                                    chartArea: { width: '80%', height: '70%' },
                                    legend: { position: 'none' },
                                    
                                    vAxis: {
                                        title: 'Jumlah WO',
                                        minValue: 0,
                                    },
                                    hAxis: {
                                        title: 'Status',
                                    },
                                    bar: { groupWidth: "20%" },
                                };

                                const chart = new google.visualization.ColumnChart(document.getElementById('kt_docs_google_chart_bar'));
                                chart.draw(chartData, options);
                            })
                            .catch(error => console.error("Gagal ambil data WO:", error));
                    }
                });
            </script> --}}

        {{-- Script WO hanya Tampil total data WO --}}
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                fetch("{{ route('dashboard.wo-summary') }}")
                    .then(response => response.json())
                    .then(data => {
                        const total = data.total || 0;
                        const totalEl = document.getElementById("wo-total");
                        if (totalEl) totalEl.textContent = total;
                    })
                    .catch(error => console.error("Gagal ambil data WO:", error));
            });
        </script>

        {{-- SCRIPT MR --}}
        {{-- Script MR tampil total data + Persen Perbandingan + Grafik --}}
            {{-- <script>
                $(document).ready(function () {
                    $.ajax({
                        url: "{{ url('/dashboard/material-request-summary') }}",
                        type: "GET",
                        success: function (data) {
                            const total = data.total || 0;
                            const lastMonth = data.totalLastMonth || 0;
                            const submitted = data.submitted;
                            const inProgress = data.inProgress;
                            const done = data.done;

                            const diff = total - lastMonth;
                            const percentChange = lastMonth > 0 ? (diff / lastMonth) * 100 : 100;

                            // Format angka
                            const percentDone = total > 0 ? (done / total) * 100 : 0;
                            const formatPercent = (val) => `${val.toFixed(1)}%`;

                            $("#mr-total").text(total);

                            $("#mr-to-goal")?.text(`${done} of ${total} Material Requests Have Been Completed/Done`);
                            $("#mr-percent")?.text(formatPercent(percentDone));
                            $("#mr-progress-done")?.css("width", percentDone + "%");
                            $("#mr-progress-done")?.attr("title", `Done: ${formatPercent(percentDone)} (${done} MR)`);

                            const icon = percentChange >= 0
                                ? '<i class="ki-outline ki-arrow-up fs-3 text-success me-1"></i>'
                                : '<i class="ki-outline ki-arrow-down fs-3 text-danger me-1"></i>';
                            const textClass = percentChange >= 0 ? 'text-success' : 'text-danger';
                            const formattedChange = `${icon}${Math.abs(percentChange).toFixed(1)}%`;

                            $("#mr-change").html(`<span class="${textClass} fs-4 fw-bold d-flex align-items-center">${formattedChange}</span>`);
                        },
                        error: function (xhr) {
                            console.error("Gagal mengambil data Material Request", xhr);
                        }
                    });
                });
            </script> --}}

        {{-- Script Tampila total data MR sj--}}
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: "{{ url('/dashboard/material-request-summary') }}",
                    type: "GET",
                    success: function (data) {
                        const total = data.total || 0;
                        $("#mr-total").text(total);
                    },
                    error: function (xhr) {
                        console.error("Gagal mengambil data Material Request", xhr);
                    }
                });
            });
        </script>

        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                fetch("{{ route('dashboard.case-wo-summary') }}")
                    .then(response => response.json())
                    .then(data => {
                        var element = document.getElementById('kt_apexcharts_1');
                        var height = parseInt(KTUtil.css(element, 'height'));
                        var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                        var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');

                        if (!element) return;

                        var options = {
                            series: [
                                { name: 'Case', data: data.caseData },
                                { name: 'Work Order', data: data.woData }
                            ],
                            chart: {
                                fontFamily: 'inherit',
                                type: 'bar',
                                height: height,
                                toolbar: { show: false }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '30%',
                                    endingShape: 'rounded'
                                }
                            },
                            legend: {
                                show: true,
                                labels: {
                                    colors: labelColor,
                                    useSeriesColors: false
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            xaxis: {
                                categories: data.months,
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: {
                                    style: {
                                        colors: labelColor,
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: labelColor,
                                        fontSize: '12px'
                                    }
                                }
                            },
                            fill: {
                                opacity: 1
                            },
                            states: {
                                normal: { filter: { type: 'none', value: 0 } },
                                hover: { filter: { type: 'none', value: 0 } },
                                active: {
                                    allowMultipleDataPointsSelection: false,
                                    filter: { type: 'none', value: 0 }
                                }
                            },
                            tooltip: {
                                style: {
                                    fontSize: '12px'
                                },
                                y: {
                                    formatter: function (val) {
                                        return val + ' data';
                                    }
                                }
                            },
                            colors: ['#007bff', '#ffc107'], 
                            grid: {
                                borderColor: borderColor,
                                strokeDashArray: 4,
                                yaxis: {
                                    lines: {
                                        show: true
                                    }
                                }
                            }
                        };

                        new ApexCharts(element, options).render();
                    });
            });
        </script>
    @endif

    {{-- Script Dashboard Approval --}}
    @if(auth()->user()->hasAnyPermission(['view cr_ap','view mr_ap']))
        {{-- Script Approval Case --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('dashboard.case-approval-progress') }}')
                    .then(response => response.json())
                    .then(data => {
                        const pendingCount = data.pending ?? 0;
                        const approvedCount = data.approved ?? 0;
                        const total = data.total ?? 0;
                        const percentage = data.percentage ?? 0;

                        document.getElementById('pending-case-count').textContent = pendingCount;
                        document.getElementById('case-progress-bar').style.width = percentage + "%";

                        const progressText = (total === 0)
                            ? "No assigned case approval"
                            : `${approvedCount} of ${total} Case Approved (${percentage}%)`;

                        document.getElementById('case-progress-text').textContent = progressText;
                    })
                    .catch(error => {
                        console.error('Error fetching case approval progress:', error);
                        document.getElementById('case-progress-text').textContent = "Unable to load approval data.";
                    });
            });
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('dashboard.case-approval-progress') }}')
                    .then(response => response.json())
                    .then(data => {
                        const pendingCount = data.pending ?? 0;
                        const approvedCount = data.approved ?? 0;
                        const total = data.total ?? 0;
                        const percentage = data.percentage ?? 0;

                        // Menampilkan jumlah total case yg pending (yang harus di-approve)
                        document.getElementById('total-case-to-approve').textContent = pendingCount;

                        // Untuk progress bar dan text lain, jika kamu pakai
                        const progressBar = document.getElementById('case-progress-bar');
                        const progressText = document.getElementById('case-progress-text');

                        if (progressBar) progressBar.style.width = percentage + "%";
                        if (progressText) {
                            progressText.textContent = (total === 0)
                                ? "No assigned case approval"
                                : `${approvedCount} of ${total} Case Approved (${percentage}%)`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching case approval progress:', error);
                        const progressText = document.getElementById('case-progress-text');
                        if (progressText) {
                            progressText.textContent = "Unable to load approval data.";
                        }
                    });
            });
        </script>

        {{-- Script MR Approval By Manger --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Untuk Pending Material Request
                fetch('{{ route('ajax.pendingMRCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-mr-count').textContent = data.count;
                    });
            });
        </script> --}}
        {{-- Script MR Approval By Manager --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('ajax.pendingMRCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-mr-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching pending MR count:', error);
                        document.getElementById('pending-mr-count').textContent = "0";
                    });
            });
        </script>

        {{-- Script woc APPROVAL --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('ajax.pendingWOCCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-woc-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching pending WOC count:', error);
                    });
            });
        </script> --}}
        {{-- Script WO Completed (Need Approval) --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('ajax.pendingWOCCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-woc-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching pending WOC count:', error);
                        document.getElementById('pending-woc-count').textContent = "0";
                    });
            });
        </script>

    @endif
@endsection

      