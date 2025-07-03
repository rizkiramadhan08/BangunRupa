<!-- Footer -->
<footer class="py-4 bg-white border-top">
    <div class="container">

        <!-- Baris atas: Logo, Menu, Sosmed -->
        <div class="d-flex flex-wrap justify-content-between align-items-center">

            <!-- Logo -->
            <div class="d-flex align-items-center">
                <img src="{{ asset('img/Logo1.png') }}" alt="Logo" width="170" class="me-3" />
            </div>

            <!-- Menu Link -->
            <ul class="nav mb-2 text-center">
                <li class="nav-item"><a href="{{ route('kebijakan.privasi') }}" class="nav-link px-2 text-dark">Kebijakan
                        Privasi</a></li>
                <li class="nav-item"><a href="{{ route('syarat.ketentuan') }}" class="nav-link px-2 text-dark">Syarat
                        dan Ketentuan</a></li>
                <li class="nav-item"><a href="{{ route('form.faq') }}" class="nav-link px-2 text-dark">FAQ</a></li>
                <li class="nav-item"><a href="{{ route('kontak') }}" class="nav-link px-2 text-dark">Kontak Kami</a>
                </li>
            </ul>

            <!-- Sosial Media -->
            <div class="text-end">
                <div>
                    <a href="#" class="text-dark me-2"><i class="fa-brands fa-fw fa-facebook-f"></i></a>
                    <a href="#" class="text-dark me-2"><i class="fa-brands fa-fw fa-instagram"></i></a>
                    <a href="#" class="text-dark me-2"><i class="fa-brands fa-fw fa-whatsapp"></i></a>
                    <a href="#" class="text-dark me-2"><i class="fa-brands fa-fw fa-x-twitter"></i></a>
                    <a href="#" class="text-dark me-2"><i class="fa-solid fa-fw fa-envelope"></i></a>
                </div>
            </div>

            <!-- Baris bawah: Copyright -->
            <div class="text-center mt-2 w-100">
                <p class="mb-0">&copy; 2025 Bangun Rupa. All rights reserved.</p>
            </div>
        </div>


    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    function confirmLogout(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Kamu akan keluar dari sesi!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#0a295c',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya, logout!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                Swal.fire({
                    title: 'Melakukan logout...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Delay 1.5 detik, lalu submit form
                setTimeout(() => {
                    document.getElementById('logout-form').submit();
                }, 1500);
            }
        });
    }
</script>


</html>
