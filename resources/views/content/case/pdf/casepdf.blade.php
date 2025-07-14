<!DOCTYPE html>
<html>
    <head>
        <title>Berita Acara - {{ $case->Case_No }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                font-size: 12px;
                margin: 30px;
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
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 30px;
            }
            td {
                padding: 8px;
                vertical-align: top;
            }
            .section-title {
                font-weight: bold;
                padding-top: 15px;
                border-top: 1px solid #ccc;
            }
            .page-break {
                page-break-before: always;
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
                width: 100%;
                display: flex;
                justify-content: space-between;
            }

            .footer-left {
                text-align: left;
                line-height: 1.4;
            }

            .footer-right {
                text-align: right;
                font-weight: bold;
            }

            .pagenum:before {
                content: counter(page);
            }

            .totalpages:before {
                content: counter(pages);
            }

    </style>

    <style>
    .ttd {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin-top: 30px;
    }

    .ttd td {
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #ccc;
    }

    .ttd-title {
        font-weight: bold;
        background-color: #f2f2f2;
    }

    .ttd-subtitle {
        font-style: italic;
        background-color: #fafafa;
    }

    .ttd b {
        font-weight: bold;
    }

    .ttd-sign-space {
        height: 60px;
    }
    </style>

    </head>
<body>

    <header>
        <img src="{{ public_path('assets/media/LogoGamaTower.jpg') }}" alt="Logo">
    </header>

    <main>
        <div class="header">
            <h2>BERITA ACARA</h2>
            <h3>{{ $case->Case_Name }}</h3>
        </div>

        <table>
            <tr>
                <td width="30%" style="font-weight: bold;">No. Ref.</td>
                <td>: {{ $case->Case_No }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Hari dan Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($case->Case_Date)->translatedFormat('l, d F Y') }}</td>
            </tr>   
            <tr>
                <td style="font-weight: bold;">Dibuat Oleh</td>
                <td>: {{ $case->creator->Fullname }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Departemen</td>
                <td>: {{ $case->creator->position->PS_Name ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="section-title">I. KRONOLOGI</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #ccc;">{{ $case->Case_Chronology }}</td>
            </tr>
            <tr>
                <td colspan="2" class="section-title">II. AKIBAT YANG TERJADI</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #ccc;">{{ $case->Case_Outcome }}</td>
            </tr>
            <tr>
                <td colspan="2" class="section-title">III. SARAN</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #ccc;">{{ $case->Case_Suggest }}</td>
            </tr>
            <tr>
                <td colspan="2" class="section-title">IV. AKSI</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #ccc;">{{ $case->Case_Action }}</td>
            </tr>
        </table>

        <footer>
            <div class="footer-content">
                <div class="footer-right">
                    {{ $case->Case_No }}
                </div>
                <div class="footer-left">
                    Page <span class="pagenum"></span> of 2<br>
                    BERITA ACARA<br>
                    {{ $case->Case_Name }}
                </div>
            </div>
        </footer>
    </main>

    <div class="page-break"></div>

    <main>
        <h3 style="text-align: center; font-weight: bold;">LAMPIRAN</h3>

        {{-- @if($case->images && $case->images->isNotEmpty())
            @php $chunkedImages = $case->images->chunk(2); @endphp
            <table width="100%" cellpadding="10" cellspacing="0" style="text-align: center;">
                @foreach($chunkedImages as $rowImages)
                    <tr>
                        @foreach($rowImages as $image)
                            @php
                                $imagePath = public_path('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename);
                            @endphp
                            <td width="50%" style="border: 1px solid #ccc;">
                                <img src="{{ $imagePath }}" alt="Lampiran" style="width: 100%; height: 250px; object-fit:contain;"><br>
                            </td>
                        @endforeach

                        @for($i = $rowImages->count(); $i < 2; $i++)
                            <td width="50%"></td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        @else
            <p style="text-align: center; font-style: italic; margin-top: 10px;">No image attachments available.</p>
        @endif --}}
        @if($case->images && $case->images->isNotEmpty())
            @php $chunkedImages = $case->images->chunk(2); @endphp
            <table width="100%" cellpadding="10" cellspacing="0" style="text-align: center;">
                @foreach($chunkedImages as $rowImages)
                    <tr>
                        @foreach($rowImages as $image)
                            @php
                                $folder = str_replace(['/', '\\'], '-', $case->Case_No); // Gunakan Case_No sebagai folder
                                $imagePath = public_path("storage/case_photos/{$folder}/{$image->IMG_Filename}");
                            @endphp
                            <td width="50%" style="border: 1px solid #ccc;">
                                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imagePath))}}" alt="Lampiran" style="width: 100%; height: 250px; object-fit:contain;"><br>
                            </td>
                        @endforeach

                        {{-- Jika jumlah gambar di baris kurang dari 2, tambahkan kolom kosong --}}
                        @for($i = $rowImages->count(); $i < 2; $i++)
                            <td width="50%"></td>
                        @endfor
                    </tr>
                @endforeach
            </table>
        @else
            <p style="text-align: center; font-style: italic; margin-top: 10px;">No image attachments available.</p>
        @endif


        {{-- TTD --}}

        @php
            $maxStep = $case->Case_ApMaxStep ?? 0;
        @endphp

        <table class="ttd">
            {{-- HEADER --}}
            <tr>
                <td>-</td>
                <td class="ttd-title">Dibuat oleh</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td class="ttd-title">Disetujui oleh {{ $i }}</td>
                @endfor
            </tr>

            {{-- DEPARTEMEN --}}
            <tr>
                <td class="ttd-title">Departemen</td>
                <td class="ttd-subtitle">{{ $case->creator->position->PS_Name ?? '-' }}</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td class="ttd-subtitle">
                        {{ optional($case->{'approver'.$i}->position ?? null)->PS_Name ?? '-' }}
                    </td>
                @endfor
            </tr>

            {{-- NAMA --}}
            <tr>
                <td><b>Nama</b></td>
                <td>{{ $case->creator->Fullname }}</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td>{{ $case->{'approver'.$i}->Fullname ?? '-' }}</td>
                @endfor
            </tr>

            {{-- TANGGAL --}}
            <tr>
                <td><b>Tanggal</b></td>
                <td>{{ \Carbon\Carbon::parse($case->CR_DT)->format('d-m-Y') }}</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    @php
                        $approvalField = 'Case_AP' . $i;
                        $date = ($case->$approvalField ?? false) ? \Carbon\Carbon::parse($case->Update_Date)->format('d-m-Y') : '-';
                    @endphp
                    <td>{{ $date }}</td>
                @endfor
            </tr>

            {{-- TANDA TANGAN --}}
            <tr class="ttd-sign-space">
                <td class="ttd-subtitle">TTD</td>
                <td class="ttd-subtitle">
                    <img src="{{ public_path('assets/media/logoapv.png') }}" style="width: 100px; height: 100px; object-fit: cover;" alt="Logo">
                </td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td class="ttd-subtitle">
                        <img src="{{ public_path('assets/media/logoapv.png') }}" style="width: 100px; height: 100px; object-fit: cover;" alt="Logo">
                    </td>
                @endfor
            </tr>
        </table>


        <footer>
            <div class="footer-content">
                <div class="footer-right">
                    {{ $case->Case_No }}
                </div>
                <div class="footer-left">
                    Page <span class="pagenum"></span> of 2<br>
                    BERITA ACARA<br>
                    {{ $case->Case_Name }}
                </div>
            </div>
        </footer>
    
    </main> 
</body>
</html>
