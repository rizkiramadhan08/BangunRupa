<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desains;
use App\Models\User;
use App\Models\PurchaseHistory;

class AdminController extends Controller
{
    public function index(){
        $title = 'Dashboard';

        $totalUsers = \App\Models\User::count();
        $totalDesains = \App\Models\Desains::count();
        $users = \App\Models\User::orderBy('created_at', 'asc')->get();
        return view('admin/index', compact('users', 'title', 'totalUsers', 'totalDesains'));
    }

    public function delete_user($id)
    {
    $user = User::findOrFail($id);

    // Hindari menghapus admin diri sendiri (opsional)
    if (Auth::user()->id === $user->id) {
    return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
    }

    $user->delete();

    return back()->with('success', 'User berhasil dihapus.');
    }

    public function updateUser(Request $request, $id)
    {
    $request->validate([
        'role' => 'required|string',
        'is_active' => 'required|boolean',
    ]);

    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->is_active = $request->is_active;
    $user->save();

    return redirect()->route('admin.dashboard')->with('success', 'User berhasil diperbarui.');
    }


    public function list_desain(){
        $title = 'List Desains';

        $desains = Desains::latest()->get();
        return view('admin/list_desain', compact('desains', 'title'));
    }

    public function tambah_desain(){
        $title = 'Tambah Desains';
        return view('admin/tambah_desain', compact('title'));
    }

    public function upload_desain(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'gambar_tambahan.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_produk' => 'required|string|max:255',
            'nama_desainer' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'panjang_lahan' => 'required|numeric|min:1',
            'lebar_lahan' => 'required|numeric|min:1',
            'lantai' => 'required|integer|min:1',
            'luas_tanah' => 'required|numeric',
            'kamar_tidur' => 'required|integer|min:0',
            'luas_bangunan' => 'required|numeric',
            'kamar_mandi' => 'required|integer|min:0',
            'gaya_desain' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        // Gabungkan ukuran lahan
        $ukuran_lahan = $request->panjang_lahan . ' x ' . $request->lebar_lahan;

        // Upload gambar utama
        $file = $request->file('gambar');
        $gambarUtamaName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('img/desain'), $gambarUtamaName);

        // Upload gambar tambahan (jika ada)
        $gambarTambahan = [];
        if ($request->hasFile('gambar_tambahan')) {
            foreach ($request->file('gambar_tambahan') as $tambahan) {
                $tambahanName = time() . '_' . uniqid() . '_' . $tambahan->getClientOriginalName();
                $tambahan->move(public_path('img/desain'), $tambahanName);
                $gambarTambahan[] = $tambahanName;
            }
        }

        // Simpan ke database
        DB::table('desains')->insert([
            'gambar' => $gambarUtamaName,
            'gambar_tambahan' => json_encode($gambarTambahan), // simpan sebagai JSON
            'nama_produk' => $request->nama_produk,
            'nama_desainer' => $request->nama_desainer,
            'harga' => $request->harga,
            'ukuran_lahan' => $ukuran_lahan,
            'lantai' => $request->lantai,
            'luas_tanah' => $request->luas_tanah,
            'kamar_tidur' => $request->kamar_tidur,
            'luas_bangunan' => $request->luas_bangunan,
            'kamar_mandi' => $request->kamar_mandi,
            'gaya_desain' => $request->gaya_desain,
            'deskripsi' => $request->deskripsi,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Desain berhasil ditambahkan.');
    }

    public function delete_desain($id)
    {
    $desain = Desains::findOrFail($id);

    // Hapus gambar utama
    $pathUtama = public_path('img/desain/' . $desain->gambar);
    if (file_exists($pathUtama)) {
        unlink($pathUtama);
    }

    // Hapus gambar tambahan (jika ada)
    if ($desain->gambar_tambahan) {
        $gambarTambahan = json_decode($desain->gambar_tambahan, true);
        foreach ($gambarTambahan as $gambar) {
            $pathTambahan = public_path('img/desain/' . $gambar);
            if (file_exists($pathTambahan)) {
                unlink($pathTambahan);
            }
        }
    }

    // Hapus data dari database
    $desain->delete();

    return redirect()->route('admin.list.desain')->with('success', 'Desain berhasil dihapus.');
    }

   public function update_desain(Request $request, $id)
    {
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'nama_desainer' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'panjang_lahan' => 'required|numeric|min:1',
        'lebar_lahan' => 'required|numeric|min:1',
        'lantai' => 'required|integer|min:1',
        'luas_tanah' => 'required|numeric',
        'kamar_tidur' => 'required|integer|min:0',
        'luas_bangunan' => 'required|numeric',
        'kamar_mandi' => 'required|integer|min:0',
        'gaya_desain' => 'required|string|max:100',
        'deskripsi' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'gambar_tambahan.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'hapus_gambar_tambahan' => 'array',
        'hapus_gambar_tambahan.*' => 'string'
    ]);

    $desain = Desains::findOrFail($id);

    // ✅ Hapus thumbnail jika diminta
    if ($request->has('hapus_thumbnail') && $desain->gambar) {
        $thumbPath = public_path('img/desain/' . $desain->gambar);
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
        $desain->gambar = null;
    }

    // ✅ Ganti thumbnail jika diupload
    if ($request->hasFile('gambar')) {
        if ($desain->gambar) {
            $old = public_path('img/desain/' . $desain->gambar);
            if (file_exists($old)) unlink($old);
        }

        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('img/desain'), $filename);
        $desain->gambar = $filename;
    }

    // ✅ Kelola gambar tambahan lama
    $gambarLama = json_decode($desain->gambar_tambahan, true) ?? [];
    $gambarTersisa = [];

    if ($request->has('hapus_gambar_tambahan')) {
        $hapusList = $request->hapus_gambar_tambahan;
        foreach ($gambarLama as $gambar) {
            if (in_array($gambar, $hapusList)) {
                $path = public_path('img/desain/' . $gambar);
                if (file_exists($path)) {
                    unlink($path);
                }
            } else {
                $gambarTersisa[] = $gambar;
            }
        }
    } else {
        $gambarTersisa = $gambarLama;
    }

    // ✅ Upload gambar tambahan baru
    if ($request->hasFile('gambar_tambahan')) {
        foreach ($request->file('gambar_tambahan') as $file) {
            $namaBaru = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/desain'), $namaBaru);
            $gambarTersisa[] = $namaBaru;
        }
    }

    $desain->gambar_tambahan = count($gambarTersisa) > 0 ? json_encode($gambarTersisa) : null;

    // ✅ Data lainnya
    $desain->nama_produk = $request->nama_produk;
    $desain->nama_desainer = $request->nama_desainer;
    $desain->harga = $request->harga;
    $desain->ukuran_lahan = $request->panjang_lahan . ' x ' . $request->lebar_lahan;
    $desain->lantai = $request->lantai;
    $desain->luas_tanah = $request->luas_tanah;
    $desain->kamar_tidur = $request->kamar_tidur;
    $desain->luas_bangunan = $request->luas_bangunan;
    $desain->kamar_mandi = $request->kamar_mandi;
    $desain->gaya_desain = $request->gaya_desain;
    $desain->deskripsi = $request->deskripsi;

    $desain->save();

    return redirect()->route('admin.list.desain')->with('success', 'Desain berhasil diperbarui.');
    }


    public function list_transaksi()
    {
        $title = 'List Transaksi';

        $transaksis_lunas = PurchaseHistory::where('status', 'lunas')->with('user', 'desain')->get();
        $transaksis_belum = PurchaseHistory::where('status', '!=', 'lunas')->with('user', 'desain')->get();

        return view('admin/list_transaksi', compact('transaksis_lunas', 'transaksis_belum', 'title'));
    }

    public function update_transaksi(Request $request, $id)
    {
    $transaksi = PurchaseHistory::findOrFail($id);
    $transaksi->status = $request->status;
    $transaksi->save();

    return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

}
