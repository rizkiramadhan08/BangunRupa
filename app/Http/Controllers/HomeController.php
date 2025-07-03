<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Desains;

class HomeController extends Controller
{
    public function index(){
        $title = 'Beranda';

        $desainsTerbaru = Desains::latest()->take(4)->get(); // Ambil 4 desain terbaru
        $desainsRatingTerbaik = Desains::withAvg('ratings', 'rating')
            ->having('ratings_avg_rating', '>', 0)
            ->orderByDesc('ratings_avg_rating')
            ->take(4)
            ->get();

        return view('home/index', compact('title', 'desainsTerbaru', 'desainsRatingTerbaik'));
    }

    public function kebijakan_privasi(){
        $title = 'Kebijakan Privasi';

        return view ('home/kebijakan_privasi', compact('title'));
    }

    public function syarat_ketentuan(){
        $title = 'Syarat dan Ketentuan';

        return view ('home/syarat_ketentuan', compact('title'));
    }

    public function form_faq(){
        $title = 'FAQ';

        return view ('home/form_faq', compact('title'));
    }

    public function kontak(){
        $title = 'Kontak Kami';

        return view ('home/kontak', compact('title'));
    }

}