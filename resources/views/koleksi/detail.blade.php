@include('template.header')

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Poppins', sans-serif, Arial, sans-serif;
    }

    .main-container {
        margin-top: 100px;
    }

    .btn-buy {
        background-color: #f28c28;
        border: none;
        color: white;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-buy:hover,
    .btn-buy:focus {
        background-color: #d9781d;
        color: white;
    }

    .info-box,
    .description-box {
        border: 2px solid #25408f;
        border-radius: 12px;
        padding: 1.5rem;
        background: #fff;
        box-shadow: 0 4px 8px rgb(0 0 0 / 0.05);
    }

    .info-box strong {
        font-weight: 700;
    }

    .info-box {
        height: 493px;
    }

    .info-box li {
        margin-bottom: 1rem;
    }

    h5,
    .subtext {
        font-weight: 600;
    }

    .subtext a {
        color: #1d64d6;
        text-decoration: none;
    }

    .subtext a:hover,
    .subtext a:focus {
        text-decoration: underline;
    }

    .cursor-pointer {
        cursor: pointer;
    }


    @media (max-width: 767.98px) {

        .info-box,
        .description-box {
            margin-top: 2rem;
        }
    }
</style>

<!-- Main Content -->
<main class="container main-container">
    <div class="row gy-4 gy-md-0 align-items-start">

        <!-- Carousel Gambar -->
        <div class="col-md-7 d-flex justify-content-center align-items-center">
            <div id="rumahCarousel" class="carousel slide" data-bs-ride="carousel" style="width: 854.67px; height: 641px;">
                <div class="carousel-inner h-100 rounded-3">
                    <!-- Gambar utama -->
                    <div class="carousel-item active h-100">
                        <img src="{{ asset('img/desain/' . $desain->gambar) }}"
                            class="cursor-pointer d-block w-100 h-100 object-fit-cover rounded-3" alt="Gambar utama"
                            data-bs-toggle="modal" data-bs-target="#imageModal"
                            data-img="{{ asset('img/desain/' . $desain->gambar) }}">
                    </div>

                    <!-- Gambar tambahan -->
                    @php
                        $gambarTambahan = json_decode($desain->gambar_tambahan, true);
                    @endphp

                    @if ($gambarTambahan && is_array($gambarTambahan))
                        @foreach ($gambarTambahan as $gambar)
                            <div class="carousel-item h-100">
                                <img src="{{ asset('img/desain/' . $gambar) }}"
                                    class="cursor-pointer d-block w-100 h-100 object-fit-cover rounded-3"
                                    alt="Gambar tambahan" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    data-img="{{ asset('img/desain/' . $gambar) }}">
                            </div>
                        @endforeach
                    @endif
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#rumahCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#rumahCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Berikutnya</span>
                </button>
            </div>
        </div>

        <!-- Modal Tampilan Gambar -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body p-0">
                        <img id="modalImage" src="" class="w-100 rounded-3"
                            style="max-height: 95vh; object-fit: contain;" alt="Full Image">

                    </div>
                </div>
            </div>
        </div>

        <!-- Info -->
        <div class="col-12 col-md-5">
            <h3 class="mb-2 fw-bold">{{ $desain->nama_produk }}</h3>
            <p class="subtext mb-4">Didesain oleh <a
                    class="text-primary">{{ $desain->nama_desainer ?? 'Tidak Diketahui' }}</a></p>
            @auth
                <a href="{{ route('koleksi.beli', $desain->id) }}" class="btn btn-buy w-100 mb-4">
                    Beli Sekarang
                </a>
            @else
                <button type="button" class="btn btn-buy w-100 mb-4 btn-alert-login">
                    Beli Sekarang
                </button>
            @endauth
            <div class="info-box">
                <p class="mb-2 fw-semibold">Biaya Kontruksi dimulai dari</p>
                <h4 class="fw-bold text-dark mb-3">Rp{{ number_format($desain->harga, 0, ',', '.') }}</h4>
                <ul class="list-unstyled mb-0" style="line-height: 2.3;">
                    <li><strong>Ukuran Lahan :</strong> {{ $desain->ukuran_lahan }}</li>
                    <li><strong>Lantai :</strong> {{ $desain->lantai }}</li>
                    <li><strong>Luas Tanah :</strong> {{ $desain->luas_tanah }} m&sup2;</li>
                    <li><strong>Kamar tidur :</strong> {{ $desain->kamar_tidur }}</li>
                    <li><strong>Luas Bangunan :</strong> {{ $desain->luas_bangunan }} m&sup2;</li>
                    <li><strong>Kamar mandi :</strong> {{ $desain->kamar_mandi }}</li>
                    <li><strong>Gaya Desain :</strong> {{ $desain->gaya_desain }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <section class="description-box mt-5 mx-auto" style="max-width: 1400px;">
        <h5 class="text-center text-primary fw-bold mb-3">Deskripsi</h5>
        <p id="deskripsiText" class="m-0 text-secondary" style="text-align: justify; white-space: pre-line;"></p>

    </section>

    <!-- Rating dan Ulasan Scroll Vertikal tanpa border belakang -->
    <section class="mt-5 mb-5 mx-auto">
        <h5 class="text-center text-primary fw-bold mb-3">Rating</h5>
        <div class="d-flex align-items-start gap-4">
            <!-- Box Rata-rata Rating -->
            <div class="border border-primary rounded-3 p-4 text-center d-flex flex-column justify-content-center"
                style="height: 300px;">
                <div class="text-warning" style="font-size: 3rem; font-weight: bold;">
                    &#9733; {{ number_format($averageRating, 1) }}
                </div>
                <div class="fs-5 text-muted">/5</div>
                <div class="fw-semibold fs-6">{{ $ratings->count() }} Ulasan</div>
            </div>

            <!-- Daftar Komentar -->
            <div class="flex-grow-1 shadow-sm overflow-auto" style="max-height: 300px;">
                @forelse ($ratings as $r)
                    <div class="rounded p-3 mb-3" style="background: #fff;">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <img src="{{ asset('img/profil/' . ($r->user->image ?? 'default.jpg')) }}"
                                class="rounded-circle" width="40" height="40" alt="{{ $r->user->name }}">
                            <div>
                                <strong class="fs-5 me-2">{{ $r->user->name }}</strong>
                                <small class="text-muted">{{ $r->created_at->translatedFormat('d F Y') }}</small>
                            </div>
                        </div>
                        <div class="text-warning mb-1" style="font-size: 1.25rem;">
                            {!! str_repeat('&#9733;', $r->rating) . str_repeat('&#9734;', 5 - $r->rating) !!}
                        </div>
                        <p class="mb-0 small text-secondary">{{ $r->komentar }}</p>
                    </div>
                @empty
                    <p class="text-muted">Belum ada ulasan.</p>
                @endforelse
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alertLoginButtons = document.querySelectorAll('.btn-alert-login');
        alertLoginButtons.forEach(button => {
            button.addEventListener('click', function() {
                Swal.fire({
                    title: 'Login Diperlukan',
                    text: 'Silakan login terlebih dahulu untuk membeli desain.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('login') }}";
                    }
                });
            });
        });


        const modalImage = document.getElementById('modalImage');
        document.querySelectorAll('[data-bs-toggle="modal"]').forEach(img => {
            img.addEventListener('click', function() {
                const src = this.getAttribute('data-img');
                modalImage.setAttribute('src', src);
            });
        });

        const fullText = @json($desain->deskripsi ?? 'Deskripsi belum tersedia.');
        const maxLength = 400;

        const textElement = document.getElementById('deskripsiText');
        let isExpanded = false;

        if (fullText.length <= maxLength) {
            textElement.textContent = fullText;
        } else {
            const shortText = fullText.substring(0, maxLength).trim();

            const updateText = () => {
                textElement.innerHTML = isExpanded ?
                    `${fullText} <a href="javascript:void(0);" id="toggleDeskripsi" class="text-decoration-none ms-1">Sembunyikan</a>` :
                    `${shortText}... <a href="javascript:void(0);" id="toggleDeskripsi" class="text-decoration-none ms-1">Lihat Selengkapnya</a>`;
            };

            updateText();

            textElement.addEventListener('click', function(e) {
                if (e.target.id === 'toggleDeskripsi') {
                    isExpanded = !isExpanded;
                    updateText();
                }
            });
        }
    });
</script>

@include('template.footer')
