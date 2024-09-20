<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use Illuminate\Http\Request;

class ApiPengurusController extends Controller
{

    public function index()
    {
        $pengurus = Pengurus::all();
        return response()->json($pengurus);
    }
}
