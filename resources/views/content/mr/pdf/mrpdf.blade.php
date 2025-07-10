<!DOCTYPE html>
<html>
<head>
    <title>Material Request - {{ $mr->Mat_No }}</title>
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
            margin-top: 30px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header-title">Material Request Form</div>

    <table class="table-info">
        <tr>
            <td width="20%"><strong>No. MR</strong></td>
            <td>: {{ $mr->Mat_No }}</td>
        </tr>
        <tr>
            <td><strong>Hari dan Tanggal</strong></td>
            <td>: {{ \Carbon\Carbon::parse($mr->Mat_Date)->translatedFormat('l, d F Y') }}</td>
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
            <td>: {{ $mr->Mat_Purpose }}</td>
        </tr>
    </table>

    <div class="section">
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
                @foreach($mr->details as $i => $detail)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $detail->MRD_Qty }}</td>
                    <td>{{ $detail->MRD_Uom }}</td>
                    <td>{{ $detail->MRD_ItemCode }}</td>
                    <td style="text-align: left;">{{ $detail->MRD_ItemName }}</td>
                    <td>{{ $detail->MRD_Stock ?? '-' }}</td>
                    <td style="text-align: left;">{{ $detail->MRD_Remark }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <table class="ttd-table">
            <tr style="background-color: #f2f2f2;">
                <td>Departemen</td>
                <td>Dibuat oleh</td>
                @for($i = 1; $i <= $mr->Mat_MaxApv; $i++)
                    <td>Disetujui oleh {{ $i }}</td>
                @endfor
            </tr>
            <tr>
                <td>Departemen</td>
                <td>{{ $mr->creator->position->PS_Name ?? '-' }}</td>
                @for($i = 1; $i <= $mr->Mat_MaxApv; $i++)
                    <td>{{ $mr->{'approver'.$i}->position->PS_Name ?? '-' }}</td>
                @endfor
            </tr>
            <tr>
                <td>Nama</td>
                <td>{{ $mr->creator->Fullname }}</td>
                @for($i = 1; $i <= $mr->Mat_MaxApv; $i++)
                    <td>{{ $mr->{'approver'.$i}->Fullname ?? '-' }}</td>
                @endfor
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>{{ \Carbon\Carbon::parse($mr->CR_DT)->format('d-m-Y') }}</td>
                @for($i = 1; $i <= $mr->Mat_MaxApv; $i++)
                    <td>
                        @php
                            $field = 'Mat_AP' . $i;
                            $date = $mr->$field ? \Carbon\Carbon::parse($mr->Update_Date)->format('d-m-Y') : '-';
                        @endphp
                        {{ $date }}
                    </td>
                @endfor
            </tr>
            <tr>
                <td>TTD</td>
                <td></td>
                @for($i = 1; $i <= $mr->Mat_MaxApv; $i++)
                    <td>
                        @if($mr->{'Mat_AP' . $i})
                            <img src="{{ public_path('assets/media/logoapv.png') }}" width="80px">
                        @endif
                    </td>
                @endfor
            </tr>
        </table>
    </div>

    <div style="text-align: right; margin-top: 20px; font-size: 11px;">
        Page 1 of 2 | {{ $mr->Mat_No }}
    </div>

</body>
</html>
