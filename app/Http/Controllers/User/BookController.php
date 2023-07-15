<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\SendReferenceToStudent;
use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookController extends Controller
{



    public function index()
    {

        $booksToPickUp = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to release')->with('book')->get();
        $booksReleased = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'released')->with('book')->get();
        $booksToReturn = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'to return')->with('book')->get();
        $booksReturned = Transaction::where('user_id', '=', Auth::user()->id)->where('status', '=', 'returned')->with('book')->get();

        $userBookTransactionCount = Transaction::where('user_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->orWhere('status', '=', 'to release');
                $query->orWhere('status', '=', 'released');
                $query->orWhere('status', '=', 'to return');
            })
            ->count();


        $numberOfBooksToBorrowPolicy = (int)env('NUMBER_BOOKS_TO_BORROW');


        $majorBooksCount = 0;
        $genedBooksCount = 0;

        $userBookOnTransactionIds = Transaction::where('user_id', '=', Auth::user()->id)
            ->where(function ($query) {
                $query->orWhere('status', '=', 'to release');
                $query->orWhere('status', '=', 'released');
                $query->orWhere('status', '=', 'to return');
            })
            ->pluck('book_id');


        if ($userBookOnTransactionIds->count() === 1) {

            $userBooks = Book::whereIn('id', $userBookOnTransactionIds)->get(['name', 'author', 'category', 'publication_date']);


            $majorBooks = DB::table('books')
                ->select('id', "name", 'author',  'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
                ->where('status', '=', null)
                ->where('category', '=', Auth::user()->student->course)
                ->whereNot(function (QueryBuilder $query) use ($userBooks) {
                    $query->where('name', '=', $userBooks[0]->name);
                    $query->where('author', '=', $userBooks[0]->author);
                    $query->where('category', '=', $userBooks[0]->category);
                    $query->where('publication_date', '=', $userBooks[0]->publication_date);
                })
                ->groupBy('category', 'name', 'author', 'publication_date')
                ->get();

            $majorBooksCount = $majorBooks->count();

            $genedBooks = DB::table('books')
                ->select('id', "name", 'author',  'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
                ->where('status', '=', null)
                ->where('category', '=', 'GENED')
                ->whereNot(function (QueryBuilder $query) use ($userBooks) {
                    $query->where('name', '=', $userBooks[0]->name);
                    $query->where('author', '=', $userBooks[0]->author);
                    $query->where('category', '=', $userBooks[0]->category);
                    $query->where('publication_date', '=', $userBooks[0]->publication_date);
                })
                ->groupBy('category', 'name', 'author', 'publication_date')
                ->get();

            $genedBooksCount = $genedBooks->count();

            //REACH AVAILABLE BOOKS TO BORROW
        } elseif ($userBookOnTransactionIds->count() === $numberOfBooksToBorrowPolicy) {

            $userBooks = Book::whereIn('id', $userBookOnTransactionIds)->get(['name', 'author', 'category', 'publication_date']);

            $majorBooks = DB::table('books')
                ->select('id', "name", 'author', 'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
                ->where('status', '=', null)
                ->where('category', '=', Auth::user()->student->course)
                ->whereNot(function (QueryBuilder $query) use ($userBooks) {
                    $query->where('name', '=', $userBooks[0]->name);
                    $query->where('author', '=', $userBooks[0]->author);
                    $query->where('category', '=', $userBooks[0]->category);
                    $query->where('publication_date', '=', $userBooks[0]->publication_date);
                })
                ->whereNot(function (QueryBuilder $query) use ($userBooks) {
                    $query->where('name', '=', $userBooks[1]->name);
                    $query->where('author', '=', $userBooks[1]->author);
                    $query->where('category', '=', $userBooks[1]->category);
                    $query->where('publication_date', '=', $userBooks[1]->publication_date);
                })
                ->groupBy('category', 'name', 'author', 'publication_date')
                ->get();

            $majorBooksCount = $majorBooks->count();

            $genedBooks = DB::table('books')
                ->select('id', "name", 'author', 'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
                ->where('status', '=', null)
                ->where('category', '=', 'GENED')
                ->whereNot(function (QueryBuilder $query) use ($userBooks) {
                    $query->where('name', '=', $userBooks[0]->name);
                    $query->where('author', '=', $userBooks[0]->author);
                    $query->where('category', '=', $userBooks[0]->category);
                    $query->where('publication_date', '=', $userBooks[0]->publication_date);
                })
                ->whereNot(function (QueryBuilder $query) use ($userBooks) {
                    $query->where('name', '=', $userBooks[1]->name);
                    $query->where('author', '=', $userBooks[1]->author);
                    $query->where('category', '=', $userBooks[1]->category);
                    $query->where('publication_date', '=', $userBooks[1]->publication_date);
                })
                ->groupBy('category', 'name', 'author', 'publication_date')
                ->get();

            $genedBooksCount = $genedBooks->count();
        } else {
            $userBooks = Book::whereIn('id', $userBookOnTransactionIds)->get(['name', 'author', 'category', 'publication_date']);

            $majorBooks = DB::table('books')
                ->select('id', "name", 'author',  'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
                ->where('status', '=', null)
                ->where('category', '=', Auth::user()->student->course)
                ->groupBy('category', 'name', 'author', 'publication_date')
                ->get();

            $majorBooksCount = $majorBooks->count();

            $genedBooks = DB::table('books')
                ->select('id', "name", 'author', 'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
                ->where('status', '=', null)
                ->where('category', '=', 'GENED')
                ->groupBy('category', 'name', 'author', 'publication_date')
                ->get();

            $genedBooksCount = $genedBooks->count();
        }

        $unavailableMajorBooks = DB::table('books')
            ->select('id', "name", 'author',  'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
            ->where('status', '=', 'reserved')
            ->where('category', '=', Auth::user()->student->course)
            ->groupBy('category', 'name', 'author', 'publication_date')
            ->get();

        $unavailableGenedBooks = DB::table('books')
            ->select('id', "name", 'author',  'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
            ->where('status', '=', 'reserved')
            ->where('category', '=', 'GENED')
            ->groupBy('category', 'name', 'author', 'publication_date')
            ->get();

        // dd($unavailableMajorBooks);

        $totalBooks = $majorBooksCount + $genedBooksCount;

        $imgStatus = Auth::user()->student->img_path;

        return view('student.books.index', [
            'majorBooks' => $majorBooks,
            'genedBooks' => $genedBooks,
            'totalBooks' => $totalBooks,
            'booksToPickUp' => $booksToPickUp,
            'booksReleased' => $booksReleased,
            'booksToReturn' => $booksToReturn,
            'booksReturned' => $booksReturned,
            'imgStatus' => $imgStatus,
            'userBookTransactionCount' => $userBookTransactionCount,
            'numberOfBooksToBorrowPolicy' => $numberOfBooksToBorrowPolicy,
            'unavailableMajorBooks' => $unavailableMajorBooks,
            'unavailableGenedBooks' => $unavailableGenedBooks,
        ]);
    }

    public function create(Request $request)
    {
        $bookId = $request->post('bId');

        $book = Book::findOrFail($bookId);

        if($book->status == 'reserved'){
            return redirect()->route('user.books')->with('error', "The book you're trying to borrow has been already reserved by another student. We're very sorry for the inconvience.");
        }else{
            $book->status = "reserved";
            $book->save();
    
            $transaction = new Transaction();
            $transaction->book_id = $book->id;
            $transaction->reference = uniqid();
            $transaction->status = 'to release';
            $transaction->user()->associate(Auth::user());
            $transaction->save();
    
            Mail::to(Auth::user())->send(
                new SendReferenceToStudent($transaction->reference)
            );
    
            return redirect()->route('user.books')->with('success', 'Book successfully reserved for borrow');
        }


    }

    public function destroy(Request $request)
    {
        $transactionId = $request->post('tIdR');
        $transaction = Transaction::find($transactionId);

        if(!$transaction){
            return redirect()->route('user.books')->with('error', 'Unable to Cancel Book Transaction. Book transaction is already been deleted due to 2 hours transaction validity rule');   
        }else{
            if($transaction->status == 'to release'){
                $book = Book::findOrFail($transaction->book_id);
                $book->status = null;
                $book->save();
        
                $transaction->delete();
                return redirect()->route('user.books')->with('success', 'Book successfully cancel to borrow');
            }else{
                return redirect()->route('user.books')->with('error', 'Unable to Cancel Book Transaction. Book already been released');
            }
        }
    }
}
