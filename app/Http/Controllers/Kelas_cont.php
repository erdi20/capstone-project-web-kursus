<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Kelas_cont extends Controller
{
    public function show()
    {
        // Langsung tampilkan view tanpa mengirimkan data apapun.
        // $path = Storage::url('storage/images/20241211_085802.jpg');
        // return view('class.class')->with('path', $path); 
        return view('class.class'); 
    }
}
