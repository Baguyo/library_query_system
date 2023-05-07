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

        $booksToReleaseId = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to release')->with('book')->pluck('book_id')->toArray();
        $booksToReturnId = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to return')->with('book')->pluck('book_id')->toArray();
        $booksReleasedId = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'released')->with('book')->pluck('book_id')->toArray();
        
        $books = Book::all()->except($booksToReleaseId)->except($booksToReturnId)->except($booksReleasedId)->count();
        return view('student.dashboard', [
            'books' => $books,
            'booksToPickUp'=>$booksToPickUp,
            'booksReleased' => $booksReleased,
            'booksToReturn'=>$booksToReturn,
            'booksReturned'=>$booksReturned,
        ]);
    }
}
