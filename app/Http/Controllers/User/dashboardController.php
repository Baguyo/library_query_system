<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function index(){
        $booksToPickUp = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to release')->with('book')->count();
        $booksReleased = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'released')->with('book')->count();
        $booksToReturn = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to return')->with('book')->count();
        $booksReturned = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'returned')->with('book')->count();
        

        $majorBooks = Book::all()->where('status', '=', null)->where('category', '=', Auth::user()->student->course)->count();
        $genedBooks = Book::all()->where('status', '=', null)->where('category', '=', 'GENED')->count();

        $totalUserAvailableBooks = $majorBooks + $genedBooks;
        

        return view('student.dashboard', [
            'books' => $totalUserAvailableBooks,
            'booksToPickUp'=>$booksToPickUp,
            'booksReleased' => $booksReleased,
            'booksToReturn'=>$booksToReturn,
            'booksReturned'=>$booksReturned,
        ]);
    }
}
