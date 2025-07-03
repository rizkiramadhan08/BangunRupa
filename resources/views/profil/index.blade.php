@include('template.header')

<style>
    .profile-pic {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
    }

    .form-container {
        max-width: 600px;
    }

    .btn-custom {
        background-color: #002b5b;
        color: white;
    }

    .btn-custom:hover {
        background-color: #001f40;
    }
</style>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row justify-content-center align-items-center w-100">
        <!-- Profile Picture Section -->
        <div class="col-md-4 text-center mb-4 mb-md-0">
            <img src="{{ asset('img/profil/' . Auth::user()->image) }}" alt="Foto Profil" class="profile-pic mb-3"><br>

            <!-- Tombol untuk buka modal -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fotoModal">
                Ganti Foto Profil
            </button>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="formUpdateFoto" action="{{ route('profil.updatePhoto') }}" method="POST"
                    enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="fotoModalLabel">Ganti Foto Profil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Form Section -->
        <div class="col-md-6 form-container">
            <form id="formUpdateProfil" action="{{ route('profil.updateProfil') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <div class="input-group">
                        <input type="text" name="name" class="form-control"
                            value="{{ Auth::user()->name ?? '' }}">
                        <span class="input-group-text"><i class="fa fa-pencil-alt"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Hp</label>
                    <div class="input-group">
                        <input type="text" name="no_hp" placeholder="Nomor Handphone" class="form-control"
                            value="{{ Auth::user()->no_hp ?? '' }}">
                        <span class="input-group-text"><i class="fa fa-pencil-alt"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" class="form-control"
                            value="{{ Auth::user()->email ?? '' }}">
                        <span class="input-group-text"><i class="fa fa-pencil-alt"></i></span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <div class="input-group">
                        <input type="text" name="city" placeholder="Kota" class="form-control"
                            value="{{ Auth::user()->city ?? '' }}">
                        <span class="input-group-text"><i class="fa fa-pencil-alt"></i></span>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Konfirmasi simpan profil
    document.getElementById('formUpdateProfil').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Apakah Anda yakin ingin menyimpan perubahan profil?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0a295c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                setTimeout(() => {
                    e.target.submit();
                }, 1500); // delay 1.5 detik
            }
        });
    });

    // Konfirmasi ganti foto profil
    document.getElementById('formUpdateFoto').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Ganti Foto Profil?',
            text: 'Foto baru akan menggantikan yang lama.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0a295c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ganti',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Mengunggah foto...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                setTimeout(() => {
                    e.target.submit();
                }, 1500); // delay 1.5 detik
            }
        });
    });

    // SweetAlert jika session success tersedia
    const flashSuccess = "{{ session('success') }}";
    if (flashSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: flashSuccess,
            confirmButtonColor: '#0a295c'
        });
    }
</script>


@include('template.footer')
