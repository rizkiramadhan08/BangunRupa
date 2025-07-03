@include('template.header')

<style>
    body {
        background-color: #f5f5f5;
    }

    .hero {
        background: linear-gradient(to right, #1557c2, #0a295c);
        color: white;
        padding: 40px 0;
        text-align: center;
        margin-top: 50px;
    }

    .search-bar {
        max-width: 500px;
        margin: 20px auto;
    }

    .pagination {
        justify-content: center;
    }

    .btn-custom {
        color: #0a295c;
        border: 1px solid #0a295c;
    }

    .btn-custom:hover {
        background-color: #0a295c;
        color: white;
    }
</style>

<div class="hero">
    <h1 class="fw-bold">Wujudkan Kenyamananmu<br>Dengan Desain Impianmu !!!</h1>
    <form class="input-group search-bar" method="GET" action="{{ route('koleksi') }}">
        <input type="text" class="form-control" placeholder="Cari desain" name="search" value="{{ request('search') }}">
        <button class="btn btn-warning" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

</div>

<div class="container my-5">
    <h1 class="fw-bold mb-4" style="font-size: 48px;">Koleksi</h1>
    <div class="row row-cols-1 row-cols-md-4 g-4">
        @foreach ($desains as $desain)
            <div class="col">
                <div class="card shadow-sm h-100 d-flex flex-column">
                    <img src="{{ asset('img/desain/' . $desain->gambar) }}" class="card-img-top"
                        alt="{{ $desain->nama_produk }}" style="height: 200px; object-fit: cover;" />
                    <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                        <h5 class="card-title fw-semibold mb-1">{{ $desain->nama_produk }}</h5>
                        <p class="text-muted mb-3">{{ $desain->nama_desainer }}</p>
                        <div class="d-flex align-items-start mb-2">
                            <i class="bi bi-currency-dollar me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">Biaya Pembangunan</small><br />
                                <strong>Rp{{ number_format($desain->harga, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-arrows-fullscreen me-2 text-primary"></i>
                            <div>
                                <small class="text-muted">Minimal Lahan</small><br />
                                <strong>{{ str_replace('x', ' m x ', $desain->ukuran_lahan) }} m</strong>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <a href="{{ route('koleksi.detail', $desain->id) }}"
                                class="btn-custom btn btn-sm mt-auto w-100">
                                <i class="fa fa-book-open me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination">
            {{ $desains->links() }}
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.js"></script>



@include('template.footer')
