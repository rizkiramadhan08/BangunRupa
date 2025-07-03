@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Transaksi Belum Lunas</h2>
        <div class="table-responsive mb-5">
            <table id="tableBelumLunas" class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis_belum as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $t->user->name ?? 'Tidak diketahui' }}</td>
                            <td>{{ $t->desain->nama_produk ?? 'Tidak diketahui' }}</td>
                            <td>Rp {{ number_format($t->desain->harga ?? 0, 0, ',', '.') }}</td>
                            <td><span class="badge bg-warning text-dark">Menunggu Pembayaran</span></td>
                            <td>{{ \Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                <a href="#" class="text-success me-2 btn-edit" data-id="{{ $t->id }}"
                                    data-status="{{ $t->status }}" data-nama="{{ $t->user->name ?? 'Tidak diketahui' }}"
                                    data-produk="{{ $t->desain->nama_produk ?? 'Tidak diketahui' }}"
                                    data-harga="Rp {{ number_format($t->desain->harga ?? 0, 0, ',', '.') }}"
                                    data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h2 class="mb-4">Transaksi Lunas</h2>
        <div class="table-responsive">
            <table id="tableLunas" class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis_lunas as $index => $t)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $t->user->name ?? 'Tidak diketahui' }}</td>
                            <td>{{ $t->desain->nama_produk ?? 'Tidak diketahui' }}</td>
                            <td>Rp {{ number_format($t->desain->harga ?? 0, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success">Lunas</span></td>
                            <td>{{ \Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                <a href="#" class="text-success me-2 btn-edit" data-id="{{ $t->id }}"
                                    data-status="{{ $t->status }}" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada transaksi lunas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditStatus" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Status Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label">Nama Pembeli</label>
                            <p id="edit_nama" class="form-control-plaintext fw-semibold mb-0"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <p id="edit_produk" class="form-control-plaintext fw-semibold mb-0"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <p id="edit_harga" class="form-control-plaintext fw-semibold mb-0"></p>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="menunggu">Menunggu Pembayaran</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <script>
        new DataTable('#tableTransaksi');

        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert untuk hapus
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Transaksi akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/admin/transaksi/${id}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                }).then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Berhasil!', data.message, 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('Gagal', 'Gagal menghapus transaksi',
                                            'error');
                                    }
                                });
                        }
                    });
                });
            });

            // Set data untuk modal edit
            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const status = this.getAttribute('data-status');
                    const nama = this.getAttribute('data-nama');
                    const produk = this.getAttribute('data-produk');
                    const harga = this.getAttribute('data-harga');

                    document.getElementById('edit_id').value = id;
                    document.getElementById('status').value = status;
                    document.getElementById('edit_nama').textContent = nama;
                    document.getElementById('edit_produk').textContent = produk;
                    document.getElementById('edit_harga').textContent = harga;
                    document.getElementById('formEditStatus').setAttribute('action',
                        `/admin/transaksi/${id}`);
                });
            });
        });
    </script>
@endsection
