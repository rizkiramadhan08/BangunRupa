@include('auth.auth_header')
<div class="container-fluid">
    <div class="row h-100">
        <!-- logo dan gambar -->
        <div class="col-md-6 p-0 left-img">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" class="logo" />
        </div>

        <!-- form -->
        <div class="col-md-6 gradient-bg">
            <div class="form-wrapper">
                <h1 class="text-white fw-semibold text-center mb-4">Daftarkan akun <br> anda</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label text-white">Nama</label>
                        <input type="text" class="form-control" id="nama" name="name" placeholder="nama" />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-white">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-white">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="password" />
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-white">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="password" />
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-custom">DAFTAR</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@include('auth.auth_footer')
