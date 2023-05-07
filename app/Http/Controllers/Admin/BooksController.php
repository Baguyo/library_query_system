<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBook;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\InputBag;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booksToRelease = Transaction::where('status', '=', 'to release')->with('book','user')->get();
        $booksReleased = Transaction::where('status', '=', 'released')->with('book','user')->get();
        $booksToReturn = Transaction::where('status', '=', 'to return')->with('book','user')->get();
        $booksReturned = Transaction::where('status', '=', 'returned')->with('book','user')->get();

        // $books = Book::all();
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
        ])
    ->get();

        // dd($books);
        // $books->each(function($book){
        //     $book->to_release = Transaction::where('book_id', '=', $book->id)->where('status', 'to release')->count();
        //     $book->released = Transaction::where('book_id', '=', $book->id)->where('status', 'released')->count();
        // });
        // dd($books);

        // $category = Book::all()->pluck('category')->flatten();
        // dd($category);
        return view('admin.books.index', ['books'=>$books, 'booksToRelease'=>$booksToRelease, 'booksReleased' => $booksReleased, 'booksReturned'=>$booksReturned, 'booksToReturn'=>$booksToReturn]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBook $request)
    {
        $validatedData = $request->validated();

        $book = new Book();
        $book->name = $validatedData['name'];
        $book->author = $validatedData['author'];
        $book->category = $validatedData['category'];
        $book->quantity = $validatedData['quantity'];
        $book->publication_date = $validatedData['publication_date'];
        $book->save();
        return redirect()->route('admin.books.index')->with('success', 'Book successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBook $request, $id)
    {
        $validatedData = $request->validated();
        $book = Book::findOrFail($id);

        $book->name = $validatedData['name'];
        $book->author = $validatedData['author'];
        $book->category = $validatedData['category'];
        $book->quantity = $validatedData['quantity'];
        $book->publication_date = $validatedData['publication_date'];

        $book->save();

        return redirect()->route('admin.books.index')->with('success', 'Book successfully updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function release(Request $request){

        $date = Carbon::now('asia/singapore')->toDateTimeString();
        
        $transcationId = $request->post('tIdR');    
        $transcation = Transaction::findOrFail($transcationId);
        $transcation->status = 'released';
        $transcation->release_date = $date;
        $transcation->save();

        return redirect()->route('admin.books.index')->with('success', 'Book successfully released');
    }

    public function return(Request $request){
        $date = Carbon::now('asia/singapore')->toDateTimeString();
        
        $transcationId = $request->post('tIdR');    

        $transcation = Transaction::with('book')->findOrFail($transcationId);

        //BOOK ADD QUANTITY
        // $current_quantity = $transcation->book->quantity;
        // $new_quantity = $current_quantity + 1;

        // $transcation->book->quantity = $new_quantity;

        // $transcation->book->save();
        
        $transcation->status = 'returned';
        $transcation->return_date = $date;
        $transcation->save();
        
        return redirect()->route('admin.books.index')->with('success', 'Book successfully returned');
    }

    public function ajaxView(Request $request){
         $bookId = $request->get('bookId');
         return $transactions = Transaction::where('book_id', $bookId)->with('book', 'user')->get();
    }
}
