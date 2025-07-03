@extends('layouts.admin')

@section('content')
    <h1>List Desain</h1>

    <a href="{{ route('admin.tambah.desain') }}" class="btn btn-success mb-3">
        <i class="fa fa-plus me-2"></i> Tambah Desains
    </a>

    <div class="table-responsive">
        <table id="tableDesains" class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Thumbnail</th>
                    <th>Nama Produk</th>
                    <th>Desainer</th>
                    <th>Harga</th>
                    <th>Ukuran Lahan</th>
                    <th>Lantai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($desains as $index => $desain)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            <img src="{{ asset('img/desain/' . $desain->gambar) }}" alt="Thumbnail" width="80"
                                class="img-thumbnail">
                        </td>
                        <td>{{ $desain->nama_produk }}</td>
                        <td>{{ $desain->nama_desainer }}</td>
                        <td>Rp{{ number_format($desain->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $desain->ukuran_lahan }}</td>
                        <td class="text-center">{{ $desain->lantai }}</td>
                        <td class="text-center">
                            <a href="{{ route('koleksi.detail', ['id' => $desain->id]) }}"
                                class="text-warning ms-2 me-2 text-center"><i class="fa fa-eye"></i></a>
                            <a href="#" class="text-success me-2" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $desain->id }}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form id="form-delete-{{ $desain->id }}"
                                action="{{ route('admin.delete.desain', $desain->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <a type="button" class="text-danger ms-2 me-2 text-center btn-delete"
                                    data-id="{{ $desain->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data desain.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <!-- Modal Edit -->
    @foreach ($desains as $desain)
        <div class="modal fade" id="editModal{{ $desain->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $desain->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg bg-white">
                <form method="POST" action="{{ route('admin.update.desain', $desain->id) }}" enctype="multipart/form-data"
                    class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $desain->id }}">Edit Desain</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label>Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control"
                                value="{{ $desain->nama_produk }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Nama Desainer</label>
                            <input type="text" name="nama_desainer" class="form-control"
                                value="{{ $desain->nama_desainer }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control" value="{{ $desain->harga }}"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label>Panjang Lahan (m)</label>
                            <input type="number" name="panjang_lahan" class="form-control"
                                value="{{ explode(' x ', $desain->ukuran_lahan)[0] }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Lebar Lahan (m)</label>
                            <input type="number" name="lebar_lahan" class="form-control"
                                value="{{ explode(' x ', $desain->ukuran_lahan)[1] }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Lantai</label>
                            <input type="number" name="lantai" class="form-control" value="{{ $desain->lantai }}"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label>Luas Tanah (m²)</label>
                            <input type="number" name="luas_tanah" class="form-control" value="{{ $desain->luas_tanah }}"
                                required>
                        </div>
                        <div class="col-md-3">
                            <label>Kamar Tidur</label>
                            <input type="number" name="kamar_tidur" class="form-control"
                                value="{{ $desain->kamar_tidur }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Luas Bangunan (m²)</label>
                            <input type="number" name="luas_bangunan" class="form-control"
                                value="{{ $desain->luas_bangunan }}" required>
                        </div>
                        <div class="col-md-3">
                            <label>Kamar Mandi</label>
                            <input type="number" name="kamar_mandi" class="form-control"
                                value="{{ $desain->kamar_mandi }}" required>
                        </div>
                        <div class="col-md-6">
                            <label>Gaya Desain</label>
                            <input type="text" name="gaya_desain" class="form-control"
                                value="{{ $desain->gaya_desain }}" required>
                        </div>
                        <div class="col-12">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4">{{ $desain->deskripsi }}</textarea>
                        </div>
                        <!-- Thumbnail -->
                        <div class="col-md-6">
                            <label>Ganti Thumbnail (opsional)</label>
                            <input type="file" name="gambar" class="form-control mb-2">
                            <small class="text-muted d-block">Thumbnail saat ini:</small>
                            <img src="{{ asset('img/desain/' . $desain->gambar) }}" width="100"
                                class="img-thumbnail mt-1">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_thumbnail" value="1"
                                    id="hapusThumbnail{{ $desain->id }}">
                                <label class="form-check-label" for="hapusThumbnail{{ $desain->id }}">
                                    Hapus thumbnail saat ini
                                </label>
                            </div>
                        </div>

                        <!-- Gambar tambahan -->
                        <div class="col-md-6">
                            <label>Upload Gambar Tambahan Baru (opsional)</label>
                            <input type="file" name="gambar_tambahan[]" class="form-control" multiple>
                        </div>

                        @if ($desain->gambar_tambahan)
                            <div class="col-12">
                                <label class="d-block">Gambar Tambahan Saat Ini:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (json_decode($desain->gambar_tambahan, true) as $key => $gambar)
                                        <div class="position-relative" style="width: 100px;">
                                            <img src="{{ asset('img/desain/' . $gambar) }}" width="100"
                                                class="img-thumbnail">
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox"
                                                    name="hapus_gambar_tambahan[]" value="{{ $gambar }}"
                                                    id="hapusTambahan{{ $key }}_{{ $desain->id }}">
                                                <label class="form-check-label small"
                                                    for="hapusTambahan{{ $key }}_{{ $desain->id }}">
                                                    Hapus
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        new DataTable('#tableDesains');

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const desainId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data desain yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan animasi loading
                        Swal.fire({
                            title: 'Menghapus...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Tunggu sedikit agar loading sempat muncul sebelum submit
                        setTimeout(() => {
                            document.getElementById(`form-delete-${desainId}`).submit();
                        }, 800);
                    }
                });
            });
        });

        // SweetAlert untuk Update (dengan konfirmasi)
        document.querySelectorAll('form[action*="update"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // stop dulu
                Swal.fire({
                    title: 'Simpan Perubahan?',
                    text: "Perubahan akan disimpan ke database.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            form.submit();
                        }, 800);
                    }
                });
            });
        });
    </script>
@endsection
