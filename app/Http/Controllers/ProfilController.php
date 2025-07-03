<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseHistory;
use App\Models\Rating;


class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Profil';
        return view ('profil/index', compact('title'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Hapus file lama jika bukan default
        if ($user->image !== 'default.jpg' && file_exists(public_path('img/profil/' . $user->image))) {
            unlink(public_path('img/profil/' . $user->image));
        }

        // Simpan file baru
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('img/profil'), $filename);

        // Update user
        $user->image = $filename;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'city' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->no_hp = $request->input('no_hp');
        $user->email = $request->input('email');
        $user->city = $request->input('city');
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function history()
    {
    $title = 'Riwayat Pembelian'; // Ubah title agar sesuai konteks
    $userId = Auth::user()->id; // Gunakan Auth::user()->id agar lebih jelas

    $histories = PurchaseHistory::with('desain')
        ->where('user_id', $userId)
        ->latest()
        ->get();

    return view('profil.history', compact('histories', 'title'));
    }


    public function storeRating(Request $request)
    {
    $request->validate([
        'desain_id' => 'required|exists:desains,id',
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'required|string|max:1000',
    ]);

    Rating::create([
        'user_id' => Auth::id(),
        'desain_id' => $request->desain_id,
        'rating' => $request->rating,
        'komentar' => $request->komentar,
    ]);

    return response()->json(['success' => true]);
    }

    public function delete_history($id)
    {
    $history = PurchaseHistory::findOrFail($id);

    // Pastikan user yang login hanya bisa menghapus miliknya
    if ($history->user_id !== Auth::id()) {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $history->delete();

    return response()->json(['success' => true, 'message' => 'Riwayat berhasil dihapus']);
    }



}