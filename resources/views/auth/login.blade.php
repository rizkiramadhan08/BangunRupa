@include('auth.auth_header')

<div class="container-fluid">
    <div class="row h-100">
        <!-- logo dan gambar -->
        <div class="col-md-6 p-0 left-img">
            <img src="{{ asset('img/Logo.png') }}" alt="Logo" class="logo" />
        </div>

        <!-- Right side with gradient background and form -->
        <div class="col-md-6 gradient-bg">
            <div class="form-wrapper">
                <h1 class="text-white fw-semibold text-center mb-4">Login</h1>

                {{-- Tampilkan pesan error jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label text-white">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email"
                            value="{{ old('email') }}" required />
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="password" class="form-label text-white mb-0">Password</label>
                        </div>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" required />
                    </div>

                    <div class="text-white text-center mt-3">
                        Belum punya akun? <a href="{{ route('register') }}" class="text-secondary fw-semibold">Daftar di
                            sini</a>
                    </div>


                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-custom">
                            MASUK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('auth.auth_footer')
