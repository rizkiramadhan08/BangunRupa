@include('template.header')

<section class="container" style="margin-top: 90px; margin-bottom: 50px;">
    <h1 class="text-center text-primary mb-5">Kontak Kami</h1>

    <div class="row">
        <!-- Kolom Info Kontak -->
        <div class="col-md-5 mb-4">
            <div class="mb-4">
                <h3 class="fw-bold">Lokasi</h3>
                <p class="mb-0">Jl. Meruya Selatan No.1, RT.4/RW.1, Joglo</p>
                <p class="mb-0">Kec. Kembangan, Kota Jakarta Barat</p>
                <p class="mb-0">Daerah Khusus Ibukota Jakarta</p>
            </div>
            <div class="mb-4">
                <h3 class="fw-bold">WhatsApp</h3>
                <p class="mb-0">+62 813 1494 0504</p>
                <small class="text-muted">(Chat Only)</small>
            </div>
            <div class="mb-4">
                <h3 class="fw-bold">Telepon</h3>
                <p class="mb-0">021 5587234</p>
            </div>
            <div class="mb-4">
                <h3 class="fw-bold">Email</h3>
                <p class="mb-0">pelayanan@bangunrupa.co.id</p>
            </div>
        </div>

        <!-- Kolom Google Maps -->
        <div class="col-md-7">
            <div class="rounded overflow-hidden shadow-sm" style="height: 100%; min-height: 350px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.1435924635055!2d106.7360385749949!3d-6.209750662513895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f71f5a41c197%3A0x628259f9e8d6d7b4!2sUniversitas%20Mercu%20Buana!5e0!3m2!1sid!2sid!4v1719842691899!5m2!1sid!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

@include('template.footer')
