<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function quiz()
    {
        return view('students.quiz');
    }

    public function submitQuiz( Request $submission )
    {
        echo "Assignment submitted successfully.";
        echo "<br>";
        echo "Submitted Data: ";
        echo "<br>";
        print_r( $submission->all() );
    }

    public function hasilQuiz()
    {
        return view('students.hasilQuiz');
    }

    function essay()
    {
        return view('students.essay');
    }
}
