<!DOCTYPE html>
<html lang="en">

<head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>@yield('title')</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <!-- plugins:css -->  
      <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
      <!-- endinject -->

      <!-- Plugin css for this page -->

      <!-- <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
      <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
      <!-- End plugin css for this page -->

      <!-- inject:css -->
      <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
      <!-- endinject -->

      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>

<body>
    
    <div class="container-scroller">
        {{-- Header --}}
        @include('layouts.partial.header')
        {{-- End Header --}}
        
        <div class="container-fluid page-body-wrapper">
   
                {{-- Sidebar --}}
                @include('layouts.partial.sidebar')
                {{-- End Sidebar --}}
        

            {{-- Content --}}
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Content --}}
        </div>
    </div>
    

    
{{-- 
    <script>
        document.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function (e) {
                if (this.href && this.target !== "_blank") {
                    e.preventDefault(); // Mencegah pindah halaman langsung
                    const loader = document.querySelector(".page-loader");
                    loader.classList.remove("hidden"); // Tampilkan loader
                    
                    setTimeout(() => {
                        window.location.href = this.href; // Arahkan ke halaman baru setelah animasi loading muncul
                    }, 300); // Delay agar efek loading terlihat
                }
            });
        });
    </script> --}}
    
    
    

    <script>
        var hostUrl = "assets/";
    </script>
       @yield('scripts')
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <!-- <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script> -->
    <script src="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  </body>
</html>

{{-- 
public function UpdateCase(Request $request)
{
    $request->validate([
        'case_no' => 'required|string|exists:cases,Case_No',
        'cases' => 'required|string|max:255',
        'date' => 'required|date',
        'category' => 'required|string|exists:cats,Cat_No',
        'sub_category' => 'required|string|exists:subcats,Scat_No',
        'chronology' => 'required|string|max:255',
        'impact' => 'required|string|max:255',
        'suggestion' => 'required|string|max:255',
        'action' => 'required|string|max:255',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
    ]);

    try {
        Log::info('UpdateCase: Memulai proses update case', ['case_no' => $request->case_no]);

        // Update case data
        $case = Cases::where('Case_No', $request->case_no)->first();
        if (!$case) {
            Log::warning('UpdateCase: Case tidak ditemukan', ['case_no' => $request->case_no]);
            return redirect()->back()->with('error', 'Case tidak ditemukan.');
        }

        $case->Case_Name = $request->cases;
        $case->Case_Date = $request->date;
        $case->Cat_No = $request->category;
        $case->Scat_No = $request->sub_category;
        $case->Case_Chronology = $request->chronology;
        $case->Case_Outcome = $request->impact;
        $case->Case_Suggest = $request->suggestion;
        $case->Case_Action = $request->action;
        $case->Update_Date = now();
        $case->save();

        Log::info('UpdateCase: Case berhasil diperbarui', ['case_no' => $request->case_no]);

        // Handle Image Updates
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $img_no => $image) {
                $existingImage = Imgs::where('IMG_No', $img_no)->first();
                if ($existingImage) {
                    Log::info('UpdateCase: Mengupdate gambar', ['IMG_No' => $img_no]);

                    // Hapus gambar lama
                    Storage::delete('public/case_photos/' . $existingImage->IMG_RefNo . '/' . $existingImage->IMG_Filename);

                    // Simpan gambar baru
                    $newFilename = time() . '-' . $image->getClientOriginalName();
                    $image->storeAs('public/case_photos/' . $existingImage->IMG_RefNo, $newFilename);

                    // Update database
                    $existingImage->IMG_Filename = $newFilename;
                    $existingImage->IMG_Realname = $image->getClientOriginalName();
                    $existingImage->save();

                    Log::info('UpdateCase: Gambar berhasil diperbarui', ['IMG_No' => $img_no, 'filename' => $newFilename]);
                } else {
                    Log::warning('UpdateCase: Gambar tidak ditemukan', ['IMG_No' => $img_no]);
                }
            }
        }

        return redirect()->route('CreateCase')->with('success', 'Case updated successfully!');
    } catch (\Exception $e) {
        Log::error('UpdateCase: Terjadi kesalahan saat update case', [
            'case_no' => $request->case_no,
            'error' => $e->getMessage()
        ]);

        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

1. update Case_Status dari OPEN jadi SUBMIT.
2.  --}}