<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBook;
use App\Http\Requests\StoreImportBooks;
use App\Http\Requests\UpdateBook;
use App\Imports\BookImport;
use App\Models\Book;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\DB;
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
        $status = request('status') ?? 'available';

        $isNewBooksToRelease = Transaction::where('status', 'to release')->whereDate('created_at', now('asia/singapore'))->count();


        $booksToRelease = Transaction::where('status', '=', 'to release')->with('book', 'user')->get();
        $booksReleased = Transaction::where('status', '=', 'released')->with('book', 'user')->get();
        $booksToReturn = Transaction::where('status', '=', 'to return')->with('book', 'user')->get();
        $booksReturned = Transaction::where('status', '=', 'returned')->with('book', 'user')->get();

        $totalBooks = Book::all()->count();


        $books = DB::table('books')
            ->select('id', "name", 'author', 'category', 'isbn', 'control_number', 'publication_date', DB::raw("count(*) as quantity"))
            // ->where('status', '=', null)
            ->groupBy('category', 'name', 'author', 'publication_date')
            ->get();



        return view('admin.books.index', [
            'books' => $books,
            'booksToRelease' => $booksToRelease,
            'booksReleased' => $booksReleased,
            'booksReturned' => $booksReturned,
            'booksToReturn' => $booksToReturn,
            'status' => $status,
            'isNewBooksToRelease' => $isNewBooksToRelease,
            'totalBooks' => $totalBooks,
        ]);
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

        $bookCategoryCount = Book::where('category', '=', $validatedData['category'])->count();

        $book = new Book();
        $book->name = $validatedData['name'];
        $book->author = $validatedData['author'];
        $book->category = $validatedData['category'];
        $book->isbn = $validatedData['isbn'];
        $book->control_number = 'CN-' . $validatedData['category'] . - ($bookCategoryCount + 1);
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
    public function update(UpdateBook $request, $id)
    {
        $validatedData = $request->validated();
        $book = Book::findOrFail($id);

        $isbn = $request->validate([
            'isbn' => "bail|required|min:3|unique:books,isbn," . $book->id,
        ]);

        $book->name = $validatedData['name'];
        $book->author = $validatedData['author'];
        $book->category = $validatedData['category'];
        $book->isbn = $isbn['isbn'];
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
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book successfully deleted');
    }


    public function release(Request $request)
    {

        $date = Carbon::now('asia/singapore')->toDateTimeString();

        $transcationId = $request->post('tIdR');
        $transcation = Transaction::findOrFail($transcationId);
        $transcation->status = 'released';
        $transcation->release_date = $date;
        $transcation->save();

        return redirect()->route('admin.books.index', [
            'status' => 'pickUp',
        ])->with('success', 'Book successfully released');
    }

    public function return(Request $request)
    {
        $date = Carbon::now('asia/singapore')->toDateTimeString();

        $status = $request->post('status') ?? 'released';

        $transcationId = $request->post('tIdR');

        $transcation = Transaction::with('book')->findOrFail($transcationId);

        $transcation->book->status = null;
        $transcation->book->save();

        $transcation->status = 'returned';
        $transcation->return_date = $date;
        $transcation->save();

        return redirect()->route('admin.books.index', [
            'status' => $status,
        ])->with('success', 'Book successfully returned');
    }

    public function ajaxView(Request $request)
    {
        // $bookData =$request->get('bookData'); 
        $bookId = $request->get('bookId');

        return $transactions = Transaction::where('book_id', $bookId)->with('book', 'user')->get();
        // return $bookData;
    }

    public function ajaxViewBookInfo(Request $request)
    {
        $bookData = $request->get('bookData');

        $data = explode('+', $bookData);

        $booksToShow = Book::where('name', '=', $data[0])
            ->where('author', '=', $data[1])
            ->where('category', '=', $data[2])
            ->where('publication_date', '=', $data[3])
            ->get();

        return $booksToShow;
    }




    public function import(StoreImportBooks $request)
    {

        $validatedData = $request->validated();

        $rows = Excel::toArray(new BookImport(), $request->file('file'));
        foreach ($rows as $key) {
            // dump($key);
            for ($i = 1; $i < count($key); $i++) {

                $isBookExist = Book::where('name', '=', $key[$i][0])
                    ->where('author', '=', $key[$i][1])
                    ->where('category', '=', strtoupper($key[$i][2]))
                    ->where('isbn', '=', $key[$i][3])
                    ->where('publication_date', '=', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($key[$i][4])->format('Y/m/d'))
                    ->get();

                // dd($isBookExist);

                if ( count($isBookExist) === 0) {
                    // dd('book not exist');
                    $bookCategoryCount = Book::where('category', '=', strtoupper($key[$i][2]))->count();
                    // dump($key[$i][1]);
                    $book = new Book();
                    $book->name = $key[$i][0];
                    $book->author = $key[$i][1];
                    $book->category = strtoupper($key[$i][2]);
                    $book->isbn = $key[$i][3];
                    $book->control_number = 'CN-' . strtoupper($key[$i][2]) . - ($bookCategoryCount + 1);
                    $book->publication_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($key[$i][4])->format('Y/m/d');
                    $book->save();
                }
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Book successfully imported');
    }
}
