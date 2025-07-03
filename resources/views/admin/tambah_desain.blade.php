@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Tambah Desain</h2>
        <form action="{{ route('admin.upload.desain') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Rumah (Thumbnail)</label>
                <input type="file" name="gambar" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Tambahan</label>
                <input type="file" name="gambar_tambahan[]" class="form-control" multiple required>
            </div>
            <div class="mb-3">
                <label>Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nama Desainer</label>
                <input type="text" name="nama_desainer" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Ukuran Lahan</label>
                <div class="d-flex gap-2">
                    <input type="number" name="panjang_lahan" class="form-control" placeholder="Panjang" required>
                    <span class="align-self-center">x</span>
                    <input type="number" name="lebar_lahan" class="form-control" placeholder="Lebar" required>
                </div>
            </div>
            <div class="mb-3">
                <label>Lantai</label>
                <input type="number" name="lantai" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Luas Tanah</label>
                <input type="number" name="luas_tanah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kamar Tidur</label>
                <input type="number" name="kamar_tidur" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Luas Bangunan</label>
                <input type="number" name="luas_bangunan" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Kamar Mandi</label>
                <input type="number" name="kamar_mandi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Gaya Desain</label>
                <input type="text" name="gaya_desain" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Desain</button>
        </form>
    </div>
@endsection
