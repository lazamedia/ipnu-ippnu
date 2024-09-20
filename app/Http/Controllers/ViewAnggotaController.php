<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;

class ViewAnggotaController extends Controller
{

    public function index()
    {
        $pengurus = Pengurus::all(); 
        return view('anggota',[
            "title" => "Anggota",
            "active" => "anggota"
        ], compact('pengurus'));
    }
}
