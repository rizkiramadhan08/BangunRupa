@include('template.header')

<style>
    .star-rating .fa-star {
        font-size: 1.5rem;
        color: #ccc;
        /* warna default bintang */
        cursor: pointer;
        transition: color 0.3s;
    }

    .star-rating .fa-star.checked {
        color: #ffc107;
        /* warna saat dipilih (kuning) */
    }
</style>

<section class="container" style="margin-top: 90px;">
    <h2 class="mb-4 fw-bold">Produk Belum Lunas</h2>

    @php
        $belumLunas = $histories->where('status', '!=', 'lunas');
        $sudahLunas = $histories->where('status', 'lunas');
    @endphp

    @forelse ($belumLunas as $history)
        @php $desain = $history->desain; @endphp
        <div class="card mb-3">
            <div class="row g-0 align-items-center">
                <div class="col-auto">
                    <div style="width: 150px; height: 120px; overflow: hidden;" class="p-2">
                        <img src="{{ asset('img/desain/' . $desain->gambar) }}"
                            class="img-fluid object-fit-cover h-100 w-100" alt="{{ $desain->nama_produk }}">
                    </div>
                </div>
                <div class="col">
                    <div class="card-body">
                        <p class="text-muted mb-2" style="font-size: 0.875rem;">
                            {{ $history->created_at->translatedFormat('d F Y') }}
                        </p>
                        <h5 class="card-title">{{ $desain->nama_produk }}</h5>
                        <p class="text-secondary mb-2">Didesain oleh: {{ $desain->nama_desainer ?? 'Tidak Diketahui' }}
                        </p>
                        <p class="card-text mb-2">Rp {{ number_format($desain->harga, 0, ',', '.') }}</p>
                        <div class="mb-2">
                            <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                            <div class="mt-3">
                                <a href="{{ route('koleksi.detail', ['id' => $desain->id]) }}"
                                    class="btn btn-outline-info btn-sm">Lihat</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" onclick="delete_history({{ $history->id }})"
                                class="d-flex flex-column align-items-center text-decoration-none text-danger">
                                <i class="fa-solid fa-trash"></i>
                                <small>hapus</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Tidak ada pembelian yang menunggu pembayaran.</p>
    @endforelse

    <hr class="my-5">

    <h2 class="mb-4 fw-bold">Produk Sudah Lunas</h2>

    @forelse ($sudahLunas as $history)
        @php $desain = $history->desain; @endphp
        <div class="card mb-3">
            <div class="row g-0 align-items-center">
                <div class="col-auto">
                    <div style="width: 150px; height: 120px; overflow: hidden;" class="p-2">
                        <img src="{{ asset('img/desain/' . $desain->gambar) }}"
                            class="img-fluid object-fit-cover h-100 w-100" alt="{{ $desain->nama_produk }}">
                    </div>
                </div>
                <div class="col">
                    <div class="card-body">
                        <p class="text-muted mb-2" style="font-size: 0.875rem;">
                            {{ $history->created_at->translatedFormat('d F Y') }}
                        </p>
                        <h5 class="card-title">{{ $desain->nama_produk }}</h5>
                        <p class="text-secondary mb-2">Didesain oleh: {{ $desain->nama_desainer ?? 'Tidak Diketahui' }}
                        </p>
                        <p class="card-text mb-2">Rp {{ number_format($desain->harga, 0, ',', '.') }}</p>
                        <div class="mb-2">
                            <span class="badge bg-success">Lunas</span>
                        </div>
                        <a href="{{ route('koleksi.detail', ['id' => $desain->id]) }}"
                            class="btn btn-outline-info btn-sm mt-2">Lihat</a>
                        <a class="btn btn-outline-success btn-sm ms-2 mt-2" data-bs-toggle="modal"
                            data-bs-target="#ratingModal" data-desain-id="{{ $desain->id }}"
                            data-nama-produk="{{ $desain->nama_produk }}">
                            Beri Rating
                        </a>
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0);" onclick="delete_history({{ $history->id }})"
                                class="d-flex flex-column align-items-center text-decoration-none text-danger">
                                <i class="fa-solid fa-trash"></i>
                                <small>hapus</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada pembelian yang lunas.</p>
    @endforelse
</section>

<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="ratingForm" action="{{ route('rating.store') }}" method="POST">
                @csrf
                <input type="hidden" name="desain_id" id="desain_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Beri Rating & Komentar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="star-rating">
                            <i class="fa fa-star" data-value="1"></i>
                            <i class="fa fa-star" data-value="2"></i>
                            <i class="fa fa-star" data-value="3"></i>
                            <i class="fa fa-star" data-value="4"></i>
                            <i class="fa fa-star" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar</label>
                        <textarea class="form-control" name="komentar" id="comment" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('ratingModal');
        const desainIdInput = document.getElementById('desain_id');

        document.querySelectorAll('[data-bs-target="#ratingModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const desainId = this.getAttribute('data-desain-id');
                desainIdInput.value = desainId;
            });
        });

        // Handle form submit
        document.getElementById('ratingForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                desain_id: desainIdInput.value,
                rating: document.getElementById('rating').value,
                komentar: document.getElementById('comment').value,
                _token: '{{ csrf_token() }}'
            };

            fetch("{{ route('rating.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Rating berhasil dikirim!');
                        location.reload();
                    }
                });
        });

        // Star rating
        document.querySelectorAll('.star-rating .fa-star').forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                document.getElementById('rating').value = value;

                document.querySelectorAll('.star-rating .fa-star').forEach(s => s.classList
                    .remove('checked'));
                for (let i = 0; i < value; i++) {
                    document.querySelectorAll('.star-rating .fa-star')[i].classList.add(
                        'checked');
                }
            });
        });
    });

    function delete_history(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Riwayat ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading sebelum request
                Swal.fire({
                    title: 'Menghapus...',
                    html: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Lakukan fetch
                fetch(`/history/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Terhapus!',
                                text: data.message,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal',
                                'Gagal menghapus riwayat.',
                                'error'
                            );
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            'Gagal',
                            'Terjadi kesalahan pada server.',
                            'error'
                        );
                    });
            }
        });
    }
</script>

@include('template.footer')
