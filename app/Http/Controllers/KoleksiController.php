<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Desains;
use App\Models\PurchaseHistory;
use App\Models\Rating;

class KoleksiController extends Controller
{
    public function index(Request $request)
    {
    $title = 'Koleksi';
    $query = Desains::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nama_produk', 'like', '%' . $search . '%')
              ->orWhere('nama_desainer', 'like', '%' . $search . '%')
              ->orWhere('gaya_desain', 'like', '%' . $search . '%');
        });
    }

    $desains = $query->latest()->paginate(8)->withQueryString(); // agar pagination tetap membawa query search
    return view('koleksi.index', compact('title', 'desains'));
    }


    public function detail($id)
    {
    $desain = Desains::findOrFail($id);
    $title = $desain->nama_desain ?? 'Detail Koleksi'; // opsional, sesuai field di DB
    $ratings = Rating::where('desain_id', $desain->id)->latest()->get();
    $averageRating = $ratings->avg('rating');


    return view('koleksi.detail', compact('title', 'desain', 'ratings', 'averageRating'));
    }

    public function beli($id)
    {
    $user = Auth::user();

    // Simpan riwayat ke tabel
    PurchaseHistory::create([
        'user_id' => $user->id,
        'desain_id' => $id,
        'status' => 'menunggu pembayaran',
    ]);

    // Redirect ke WhatsApp
    $desain = Desains::findOrFail($id);
    $pesan = 'Halo Admin, saya tertarik dengan desain "' . $desain->nama_produk . '". Apakah masih tersedia?';
    $url = 'https://wa.me/6281234567890?text=' . urlencode($pesan);

    return redirect()->away($url);
    }

}
