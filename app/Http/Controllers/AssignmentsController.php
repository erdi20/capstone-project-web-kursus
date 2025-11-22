<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function quiz()
    {
        return view('student.quiz');
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
        return view('student.hasilQuiz');
    }

    function essay()
    {
        return view('student.essay');
    }

    function submitEssay( Request $submission )
    {
        echo "Essay submitted successfully.";
        echo "<br>";
        echo "Submitted Data: ";
        echo "<br>";
        print_r( $submission->all() );
    }
}
