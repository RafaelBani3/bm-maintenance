<!DOCTYPE html>
<html>
<head>
    <title>Material Request - {{ $mr->MR_No }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-info td {
            padding: 6px;
        }
        .table-items, .table-items th, .table-items td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        .table-items th {
            background-color: #f2f2f2;
        }
        .ttd-table {
            margin-top: 40px;
            width: 100%;
            text-align: center;
            font-size: 11px;
        }
        .ttd-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        .section {
            margin-top: 20px;
        }
        .page-break {
            page-break-after: always;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            font-size: 12px;
            font-family: Arial, sans-serif;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        
        .footer-content {
            font-size: 12px;
            margin-top: 20px;
            width: 100%;
        }

        .footer-row {
            display: flex;
            justify-content:space-between;
            width: 100%;
        }

        .footer-left {
            text-align: left;
        }

        .footer-right {
            text-align: right;
        }

        header {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        header img {
            height: 60px;
        }

        main {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }


    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('assets/media/LogoGamaTower.jpg') }}" alt="Logo">
    </header>

    <main>
        <div class="header-title">Material Request Form</div>

        <table class="table-info">
            <tr>
                <td width="20%"><strong>No. MR</strong></td>
                <td>: {{ $mr->MR_No }}</td>
            </tr>
            <tr>
                <td><strong>Hari dan Tanggal</strong></td>
                <td>: {{ \Carbon\Carbon::parse($mr->MR_Date)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td><strong>Pemesan</strong></td>
                <td>: {{ $mr->creator->Fullname }}</td>
            </tr>
            <tr>
                <td><strong>Departemen</strong></td>
                <td>: {{ $mr->creator->position->PS_Name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Peruntukan</strong></td>
                <td>: {{ $mr->MR_Allotment }}</td>
            </tr>
        </table>


        <div class="section">
            <h2>Material Request Table</h2>
            <table class="table-items">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>JUMLAH</th>
                        <th>SATUAN</th>
                        <th>ITEM CODE</th>
                        <th>ITEM / JASA</th>
                        <th>STOK</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mr->children as $detail)
                    <tr>
                        <td>{{ $detail->MR_No }}</td>
                        <td>{{ $detail->Item_Oty }}</td>
                        <td>{{ $detail->UOM_Name }}</td>
                        <td>{{ $detail->Item_Code }}</td>
                        <td style="text-align: left;">{{ $detail->Item_Name }}</td>
                        <td>{{ $detail->Item_Stock ?? '-' }}</td>
                        <td style="text-align: left;">{{ $detail->Remark }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <table class="ttd-table">
                <tr style="background-color: #f2f2f2;">
                    <td>-</td>
                    <td>Dibuat oleh</td>
                    @for($i = 1; $i <= $mr->MR_APMaxStep; $i++)
                        <td>Disetujui oleh {{ $i }}</td>
                    @endfor
                </tr>
                <tr>
                    <td>Department</td>
                    <td>{{ $mr->creator->position->PS_Name ?? '-' }}</td>
                    @for($i = 1; $i <= $mr->MR_APMaxStep; $i++)
                        <td>{{ $mr->{'approver'.$i}->position->PS_Name ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>{{ $mr->creator->Fullname }}</td>
                    @for($i = 1; $i <= $mr->MR_APMaxStep; $i++)
                        <td>{{ $mr->{'approver'.$i}->Fullname ?? '-' }}</td>
                    @endfor
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>{{ \Carbon\Carbon::parse($mr->CR_DT)->format('d-m-Y') }}</td>
                    @for($i = 1; $i <= $mr->MR_APMaxStep; $i++)
                        @php
                            $field = 'MR_AP' . $i;
                            $date = $mr->$field ? \Carbon\Carbon::parse($mr->Update_Date)->format('d-m-Y') : '-';
                        @endphp
                        <td>{{ $date }}</td>
                    @endfor
                </tr>
                <tr>
                    <td>TTD</td>
                    <td>
                        <img src="{{ public_path('assets/media/logoapv.png') }}" width="80px">
                    </td>
                    @for($i = 1; $i <= $mr->MR_APMaxStep; $i++)
                        <td>
                            @if($mr->{'MR_AP' . $i})
                                <img src="{{ public_path('assets/media/logoapv.png') }}" width="80px">
                            @endif
                        </td>
                    @endfor
                </tr>
            </table>
        </div>
    </main>
 

    <footer>
        <div class="footer-content">
            <div class="footer-row d-flex">
                <div class="footer-left">Page 1 of 1</div>
                <div class="footer-right">{{ $mr->MR_No }}</div>
            </div>
            <div class="footer-row">
                Material Request
            </div>
        </div>
    </footer>


</body>
</html>
