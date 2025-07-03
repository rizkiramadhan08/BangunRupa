@extends('layouts.admin')

<style>
    .dash-card {
        position: relative;
        border: none;
        border-radius: 1rem;
        min-height: 130px;
        color: #fff;
        overflow: hidden;
    }

    .dash-card .icon {
        position: absolute;
        right: -25px;
        bottom: -25px;
        font-size: 6rem;
        opacity: 0.15;
    }
</style>


@section('content')
    <h1 class="mb-4 text-center">Dashboard Admin</h1>

    <div class="row g-4 mt-4 mb-4">

        {{-- TOTAL USER --}}
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card dash-card bg-primary shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold small">Total User</h6>
                    <h2 class="fw-bold mb-0">{{ $totalUsers }}</h2>
                    <i class="fa fa-users icon"></i>
                </div>
            </div>
        </div>

        {{-- TOTAL DESAINS --}}
        <div class="col-12 col-md-6 col-xl-3">
            <div class="card dash-card bg-secondary shadow-sm">
                <div class="card-body">
                    <h6 class="text-uppercase fw-semibold small">Total Desains</h6>
                    <h2 class="fw-bold mb-0">{{ $totalDesains }}</h2>
                    <i class="fas fa-palette icon"></i>
                </div>
            </div>
        </div>

    </div>


    <div class="table-responsive">
        <h3 class="fw-semibold mb-3">Daftar Pengguna</h3>

        <table id="tableUser" class="table table-striped table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No Hp</th>
                    <th>City</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->city }}</td>
                        <td class="text-center">{{ ucfirst($user->role ?? 'user') }}</td>
                        <td class="text-center">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            @if ($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- Tombol Edit pakai Modal -->
                            <a href="javascript:void(0);" class="text-success me-2" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $user->id }}">
                                <i class="fa fa-edit"></i>
                            </a>

                            {{-- Tombol delete --}}
                            <form id="delete-user-form-{{ $user->id }}"
                                action="{{ route('admin.delete.user', $user->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <a href="javascript:void(0);" class="text-danger me-2 ms-2 btn-delete"
                                    data-id="{{ $user->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Edit User -->
    @foreach ($users as $user)
        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.update.user', $user->id) }}" method="POST"
                    class="modal-content form-edit-user">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="is_active" class="form-label">Status Aktif</label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


    <script>
        new DataTable('#tableUser');

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.id;
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "User yang dihapus tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            document.getElementById(`delete-user-form-${userId}`).submit();
                        }, 800);
                    }
                });
            });
        });

        document.querySelectorAll('.form-edit-user').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // tahan dulu submit

                Swal.fire({
                    title: 'Yakin ingin memperbarui?',
                    text: "Perubahan akan disimpan ke sistem.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menyimpan...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        setTimeout(() => {
                            form.submit();
                        }, 600);
                    }
                });
            });
        });
    </script>
@endsection
