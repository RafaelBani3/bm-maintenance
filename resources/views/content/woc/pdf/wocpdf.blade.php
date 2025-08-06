<!DOCTYPE html>
<html>
    <head>
        <title>Berita Acara Pekerjaan- {{ $wo->WOC_No }}</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                font-size: 12px;
            }
            header {
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
            <h2>BERITA ACARA PEKERJAAN</h2>
            <h3>{{ $wo->case->Case_Name }}</h3>
        </div>

        <table>
            <tr>
                <td width="30%" style="font-weight: bold;">No. Ref.</td>
                <td>: {{ $wo->WOC_No }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Hari dan Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($wo->WO_CompDate)->translatedFormat('l, d F Y') }}</td>
            </tr>   
            <tr>
                <td style="font-weight: bold;">Dibuat Oleh</td>
                <td>: {{ $wo->creator->Fullname }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Departemen</td>
                <td>: {{ $wo->creator->position->PS_Name ?? '-' }}</td>
            </tr>
        <tr>
                <td style="font-weight: bold;">Mulai Pekerjaan</td>
                <td>: 
                    {{ $wo->WO_Start ? \Carbon\Carbon::parse($wo->WO_Start)->translatedFormat('l, d F Y') . ' Pukul ' . \Carbon\Carbon::parse($wo->WO_Start)->format('H:i') : '-' }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Selesai Pekerjaan</td>
                <td>: 
                    {{ $wo->WO_CompDate ? \Carbon\Carbon::parse($wo->WO_CompDate)->translatedFormat('l, d F Y') . ' Pukul ' . \Carbon\Carbon::parse($wo->WO_CompDate)->format('H:i') : '-' }}
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Status Pekerjaan</td>
                <td>: {{ $wo->WO_Status ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Dikerjakan Oleh</td>
                <td>:
                    <ol style="padding-left: 15px; padding-top: 2px;">
                        @foreach ($wo->technicians_woc as $tech)
                            <li>
                                {{ $tech->technician_Name }} 
                                ( {{ $tech->position->PS_Name ?? '-' }} )
                            </li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Naratif Pekerjaan</td>
                <td>: {{ $wo->WO_Narative }}</td>
            </tr>
        </table>

        <footer>
            <table style="width: 100%; font-size: 11px;">
                <tr>
                    <td style="text-align: left;">
                        Page <span class="pagenum"></span> of <span class="totalpages">2</span>
                    </td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ $wo->WOC_No }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold;">
                        BERITA ACARA PEKERJAAN
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left;">
                        {{ $wo->case->Case_Name }}
                    </td>
                </tr>
            </table>
        </footer>
    </main>
 
    <div class="page-break"></div>

    <main>
        <h3 style="text-align: center; font-weight: bold;">LAMPIRAN</h3>

        @if($wo->images && $wo->images->isNotEmpty())
            @php $chunkedImages = $wo->images->chunk(2); @endphp
            <table width="100%" cellpadding="10" cellspacing="0" style="text-align: center;">
                @foreach($chunkedImages as $rowImages)
                    <tr>
                        @foreach($rowImages as $image)
                            @php
                                // $imagePath = public_path('storage/woc_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename);
                                $folder = str_replace(['/', '\\'], '-', $wo->WOC_No); // Gunakan Case_No sebagai folder
                                $imagePath = public_path("storage/woc_photos/{$folder}/{$image->IMG_Filename}");
                            @endphp
                            <td width="50%" style="border: 1px solid #ccc;">
                                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents($imagePath))}}" alt="Lampiran" style="width: 100%; height: 190px; object-fit: cover;"><br>
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
        @endif

        @php
            $maxStep = $wo->WO_APMaxStep ?? 0;
        @endphp

        <table class="ttd">
            <tr>
                <td>-</td>
                <td class="ttd-title">Dibuat oleh</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td class="ttd-title">Disetujui oleh {{ $i }}</td>
                @endfor
            </tr>

            <tr>
                <td class="ttd-title">Departemen</td>
                <td class="ttd-subtitle">{{ $wo->creator->position->PS_Name ?? '-' }}</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td class="ttd-subtitle">
                        {{ optional($wo->{'approver'.$i}->position ?? null)->PS_Name ?? '-' }}
                    </td>
                @endfor
            </tr>

            <tr>
                <td><b>Nama</b></td>
                <td>{{ $wo->creator->Fullname }}</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    <td>{{ $wo->{'approver'.$i}->Fullname ?? '-' }}</td>
                @endfor
            </tr>

            <tr>
                <td><b>Tanggal</b></td>
                <td>{{ \Carbon\Carbon::parse($wo->CR_DT)->format('d-m-Y') }}</td>
                @for ($i = 1; $i <= $maxStep; $i++)
                    @php
                        $approvalField = 'WO_AP' . $i;
                        $date = ($wo->$approvalField ?? false) ? \Carbon\Carbon::parse($wo->Update_Date)->format('d-m-Y') : '-';
                    @endphp
                    <td>{{ $date }}</td>
                @endfor
            </tr>

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
            <table style="width: 100%; font-size: 11px;">
                <tr>
                    <td style="text-align: left;">
                        Page <span class="pagenum"></span> of <span class="totalpages">2</span>
                    </td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ $wo->WOC_No }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold;">
                        BERITA ACARA PEKERJAAN
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left;">
                        {{ $wo->case->Case_Name }}
                    </td>
                </tr>
            </table>
        </footer>
    
    </main> 
</body>
</html>