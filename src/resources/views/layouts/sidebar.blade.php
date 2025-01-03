@php
    $currentRouteName = Route::currentRouteName();
@endphp

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <!-- Add your image here -->
            <div class="text-center py-3">
                <img src="{{ Vite::asset('resources/images/TVRI_Jawa_Timur_2023.svg') }}" alt="Logo" class="img-fluid" style="width: 80%">
            </div>
            <hr>
            <div class="nav">
                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Notes
                </a>
                <a class="nav-link" href="{{ route('stock.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Stock
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Transaksi Data
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('barangmasuk.index') }}">Barang Masuk / Kembali</a>
                        <a class="nav-link" href="{{ route('barangkeluar.index') }}">Barang Keluar</a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>
