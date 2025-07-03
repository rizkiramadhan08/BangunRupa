@include('template.header')
<link rel="stylesheet" href="{{ asset('/css/home.css') }}" />

<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-content">
        <div class="row">
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <h1 class="fw-bold text-primary mb-3">Bangun Impianmu<br>Dimulai dari Sini</h1>
                <p class="text-dark mb-4">Wujudkan hunian nyaman bersama BangunRupa</p>
                <form class="search-bar d-flex" role="search">
                    <input type="text" class="form-control" placeholder="Cari desain" />
                    <button class="btn px-4 text-white" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <img src="{{ asset('img/hero.png') }}" alt="House Image" class="hero-img" />
</section>

<!-- Konten Tambahan Scroll -->
<section class="py-5">
    <div class="container">
        <section class="py-5">
            <h1 class="fw-bold" style="font-size: 48px;">Desain Terbaru</h1>
            <div class="row row-cols-1 row-cols-md-4 g-4 mt-3">
                @foreach ($desainsTerbaru as $desain)
                    <div class="col">
                        <div class="card shadow-sm h-100 d-flex flex-column">
                            <img src="{{ asset('img/desain/' . $desain->gambar) }}" class="card-img-top"
                                alt="{{ $desain->nama_produk }}" style="height: 200px; object-fit: cover;" />
                            <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                                <h5 class="card-title fw-semibold mb-1">{{ $desain->nama_produk }}</h5>
                                <p class="text-muted mb-3">{{ $desain->nama_desainer ?? 'Tidak Diketahui' }}</p>
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
        </section>

        <section class="py-5">
            <div class="container">
                <h1 class="fw-bold mb-4" style="font-size: 48px;">Desain Terbaik</h1>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    @forelse ($desainsRatingTerbaik as $desain)
                        <div class="col">
                            <div class="card shadow-sm h-100 d-flex flex-column">
                                <img src="{{ asset('img/desain/' . $desain->gambar) }}" class="card-img-top"
                                    alt="{{ $desain->nama_produk }}" style="height: 200px; object-fit: cover;" />
                                <div class="card-body d-flex flex-column justify-content-between flex-grow-1">
                                    <h5 class="card-title fw-semibold mb-1">{{ $desain->nama_produk }}</h5>
                                    <p class="text-muted mb-2">{{ $desain->nama_desainer ?? 'Tidak Diketahui' }}</p>

                                    <div class="d-flex align-items-center text-warning mb-2">
                                        @php
                                            $avg = round($desain->ratings_avg_rating ?? 0);
                                        @endphp
                                        {!! str_repeat('<i class="fa fa-star"></i>', $avg) !!}
                                        {!! str_repeat('<i class="fa fa-star text-secondary"></i>', 5 - $avg) !!}
                                        <small class="ms-2 text-muted">
                                            ({{ number_format($desain->ratings_avg_rating ?? 0, 1) }})
                                        </small>
                                    </div>

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
                    @empty
                        <div class="col-12 text-center text-muted">
                            <p class="mt-4">Tidak ada desain yang sudah diberi rating.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Pendapat Klien Tentang kami</h2>
                <div class="row justify-content-center">

                    <!-- Card 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border rounded-4">
                            <div class="card-body text-start">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://icdn.semprebarca.com/wp-content/uploads/2025/02/Pedri-11-1536x1025.jpg"
                                        alt="Pedri" class="rounded-circle me-3"
                                        style="object-fit: cover; width: 60px; height: 60px;" />
                                    <h5 class="mb-0 fw-bold">Pedri Gonzales</h5>
                                </div>
                                <p class="text-secondary">
                                    “Pelayanan sangat memuaskan! Proses pemesanan desain rumahnya mudah dipahami,
                                    komunikasinya cepat, dan hasil akhirnya benar-benar sesuai dengan harapan. Rumah
                                    jadi terlihat lebih modern dan nyaman untuk ditinggali.”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border rounded-4">
                            <div class="card-body text-start">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://hips.hearstapps.com/hmg-prod/images/lionel-messi-celebrates-after-their-sides-third-goal-by-news-photo-1686170172.jpg"
                                        alt="Lionel Messi" class="rounded-circle me-3"
                                        style="object-fit: cover; width: 60px; height: 60px;" />
                                    <h5 class="mb-0 fw-bold">Lionel Messi</h5>
                                </div>
                                <p class="text-secondary">
                                    “Awalnya ragu menggunakan layanan desain online, tapi ternyata hasilnya sangat
                                    profesional. Desainnya detail, sesuai dengan kebutuhan, dan proses revisinya pun
                                    dilayani dengan baik. Sangat direkomendasikan!”
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border rounded-4">
                            <div class="card-body text-start">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://assets.goal.com/images/v3/getty-2149631557/crop/MM5DKMBQGU5DEOBRGU5G433XMU5DENRQHIYA====/GettyImages-2149631557.jpg?auto=webp&format=pjpg&width=3840&quality=60"
                                        alt="Frenkie" class="rounded-circle me-3"
                                        style="object-fit: cover; width: 60px; height: 60px;" />
                                    <h5 class="mb-0 fw-bold">Frenkie de Jong</h5>
                                </div>
                                <p class="text-secondary">
                                    “Saya merasa terbantu sekali dengan layanan ini. Tidak hanya desainnya menarik, tapi
                                    juga diberikan penjelasan teknis yang memudahkan saya dan keluarga memahami rencana
                                    pembangunan rumah. Sukses terus!”
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</section>

@include('template.footer')
