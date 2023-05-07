<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{



    public function index()
    {
        $booksToPickUp = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to release')->with('book')->get();
        $booksReleased = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'released')->with('book')->get();
        $booksToReturn = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to return')->with('book')->get();
        $booksReturned = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'returned')->with('book')->get();
        
        $booksToReleaseId = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to release')->with('book')->pluck('book_id')->toArray();
        $booksToReturnId = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to return')->with('book')->pluck('book_id')->toArray();
        $booksReleasedId = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'released')->with('book')->pluck('book_id')->toArray();



        // $books = Book::all()->except($booksToReleaseId)->except($booksToReturnId)->except($booksReleasedId);
        $books = Book::withCount(['transaction',
        'transaction AS to_release_count' => function($query){
            $query->where('status', '=', 'to release');
        },
        'transaction AS release_count' => function($query){
            $query->where('status', '=', 'released');
        },
        'transaction AS to_return_count' => function($query){
            $query->where('status', '=', 'to return');
        }
    ])->whereNotIn('id', $booksToReleaseId)->whereNotIn('id', $booksReleasedId)->whereNotIn('id', $booksToReturnId)->get();

        // dd($books);

        $imgStatus = Auth::user()->student->img_path;
        
        // dd($imgStatus);
        // dd($booksToReturn);
        return view('student.books.index', [
            'books' => $books,
            'booksToPickUp'=>$booksToPickUp,
            'booksReleased' => $booksReleased,
            'booksToReturn'=>$booksToReturn,
            'booksReturned'=>$booksReturned,
            'imgStatus' => $imgStatus
        ]);
    }

    public function create(Request $request)
    {


        $bookId = $request->post('bId');

        $book = Book::findOrFail($bookId);

        // $current_quantity = $book->quantity;
        // $up_quantity = $current_quantity - 1;

        // $book->quantity = $up_quantity;
        // $book->save();

        $transaction = new Transaction();
        $transaction->book_id = $bookId;
        $transaction->reference = uniqid();
        $transaction->user()->associate(Auth::user());
        $transaction->save();

        return redirect()->route('user.books')->with('success', 'Book successfully reserved for borrow');
    }

    public function destroy(Request $request){
        $transactionId = $request->post('tIdR');
        $transaction = Transaction::findOrFail($transactionId);
        
        $book = Book::findOrFail($transaction->book_id);
        // $current_quantity = $book->quantity;
        // $up_quantity = $current_quantity + 1;

        // $book->quantity = $up_quantity;
        // $book->save();

        $transaction->delete();
        return redirect()->route('user.books')->with('success', 'Book successfully cancel to borrow');
        
    }
}
