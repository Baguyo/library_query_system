<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function index(){
        $booksToPickUp = Transaction::where('status', '=', 'to release')->count();
        $booksReleased = Transaction::where('status', '=', 'released')->count();
        $booksToReturn = Transaction::where('status', '=', 'to return')->count();
        $booksReturned = Transaction::where('status', '=', 'returned')->count();
        $students = Student::all()->count();

        $books = Book::all()->count();
        return view('admin.dashboard', [
            'books' => $books,
            'booksToPickUp'=>$booksToPickUp,
            'booksReleased' => $booksReleased,
            'booksToReturn'=>$booksToReturn,
            'booksReturned'=>$booksReturned,
            'students' => $students
        ]);
    }
}
