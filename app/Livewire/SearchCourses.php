<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class SearchCourses extends Component
{
    // Variabel yang akan disinkronkan dengan input HTML
    public $searchTerm = '';
    // public $filterStatus = 'open';

    public function render()
    {
        // Pastikan Anda memanggil scope 'Open()' seperti di Controller, 
        // dan eager loading 'user'
        $courses = Course::with('user')
            // ->where('status', $this->filterStatus) // Filter berdasarkan status yang dipilih
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            })
            ->get();

            // dd($courses);

        // Perbaiki penamaan variabel: 'courses' (bukan 'cousres')
        return view('livewire.search-courses', ['courses' => $courses, 'searchTerm' => $this->searchTerm]);
    }
}
