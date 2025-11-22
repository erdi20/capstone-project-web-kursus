<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClassStudentController extends Controller
{
    public function show()
    { 
        return view('students.class'); 
    }
}
