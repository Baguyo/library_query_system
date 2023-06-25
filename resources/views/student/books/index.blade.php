@extends('student.layouts.dash')

@section('content')
    @if (session('success'))
        <p class="alert alert-success ">
            {{ Session::get('success') }}
        </p>
    @endif

    @if (session('error'))
    <p class="alert alert-danger ">
        {{ Session::get('error') }}
    </p>
    @endif  

    <div class="card">


        <div class="card-header">

            <div class="alert alert-success" role="alert">
                <h3> Your avaiable number of books to borrow : {{ $userBookTransactionCount }} /
                    {{ $numberOfBooksToBorrowPolicy }} </h3>
            </div>

            @if (!$imgStatus)
                <div class="alert alert-danger" role="alert">
                    <h1> Your image not been set. You're unable to borrow a book. </h1>
                </div>
            @endif

        </div>


        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs " id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-primary fs-5" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Books
                        to borrow <span class="badge bg-primary"> {{ $totalBooks }} </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-warning fs-5" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">
                        Books to pick up <span class="badge bg-warning">{{ $booksToPickUp->count() }}</span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-info fs-5" id="released-tab" data-bs-toggle="tab"
                        data-bs-target="#released" type="button" role="tab" aria-controls="released"
                        aria-selected="false">Books released <span class="badge bg-info"> {{ $booksReleased->count() }}
                        </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger fs-5" id="messages-tab" data-bs-toggle="tab"
                        data-bs-target="#messages" type="button" role="tab" aria-controls="messages"
                        aria-selected="false">Books to return <span class="badge bg-danger"> {{ $booksToReturn->count() }}
                        </span> </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link text-success fs-5" id="settings-tab" data-bs-toggle="tab"
                        data-bs-target="#settings" type="button" role="tab" aria-controls="settings"
                        aria-selected="false">Returned Books <span class="badge bg-success"> {{ $booksReturned->count() }}
                        </span></button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="major-books-tab" data-bs-toggle="pill"
                                data-bs-target="#major-books" type="button" role="tab" aria-controls="major-books"
                                aria-selected="true">Available Major Books</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="gened-books-tab" data-bs-toggle="pill"
                                data-bs-target="#gened-books" type="button" role="tab" aria-controls="gened-books"
                                aria-selected="false">Available GENED Books</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="unvailable-major-books-tab" data-bs-toggle="pill"
                                data-bs-target="#unvailable-major-books" type="button" role="tab"
                                aria-controls="unvailable-major-books" aria-selected="false">Unavailable Major
                                Books</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="unvailable-gened-books-tab" data-bs-toggle="pill"
                                data-bs-target="#unvailable-gened-books" type="button" role="tab"
                                aria-controls="unvailable-gened-books" aria-selected="false">Unavailable GENED
                                Books</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="major-books" role="tabpanel"
                            aria-labelledby="major-books-tab">
                            <div class="table-responsive mt-4 bg-light shadow p-3">

                                <table class="table fs-5" id="dataTableAvailableBook1" width="100%" cellspacing="0">
                                    <h6 class="text-dark">List of available Major Books</h6>
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Publication Date</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($majorBooks as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->author }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->publication_date }}</td>
                                                <td>{{ $item->quantity }}</td>

                                                <td>

                                                    @if ($imgStatus)
                                                        @if ($numberOfBooksToBorrowPolicy - $userBookTransactionCount >= 1)
                                                            <form action="{{ route('user.books') }}" method="post"
                                                                class="borrow">
                                                                @csrf
                                                                <input type="number" name="bId" class="hidden"
                                                                    readonly hidden value="{{ $item->id }}">
                                                                <input type="submit" value="Borrow"
                                                                    class="btn btn-primary">
                                                            </form>
                                                        @else
                                                            <button class="btn " disabled>
                                                                Unable to borrow
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn " disabled>
                                                            Unable to borrow
                                                        </button>
                                                    @endif


                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="gened-books" role="tabpanel" aria-labelledby="gened-books-tab">
                            <div class="table-responsive mt-4 bg-light shadow p-3">

                                <table class="table fs-5" id="dataTableAvailableBook2" width="100%" cellspacing="0">
                                    <h6 class="text-dark">List of available Gened Books</h6>
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Publication Date</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($genedBooks as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->author }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->publication_date }}</td>
                                                <td>{{ $item->quantity }}</td>

                                                <td>

                                                    @if ($imgStatus)
                                                        @if ($numberOfBooksToBorrowPolicy - $userBookTransactionCount >= 1)
                                                            <form action="{{ route('user.books') }}" method="post"
                                                                class="borrow">
                                                                @csrf
                                                                <input type="number" name="bId" class="hidden"
                                                                    readonly hidden value="{{ $item->id }}">
                                                                <input type="submit" value="Borrow"
                                                                    class="btn btn-primary">
                                                            </form>
                                                        @else
                                                            <button class="btn " disabled>
                                                                Unable to borrow
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn " disabled>
                                                            Unable to borrow
                                                        </button>
                                                    @endif


                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="unvailable-major-books" role="tabpanel"
                            aria-labelledby="unvailable-major-books-tab">
                            <div class="table-responsive mt-4 bg-light shadow p-3">

                                <table class="table fs-5" id="dataTableAvailableBook3" width="100%" cellspacing="0">
                                    <h6 class="text-dark">List of Unavailable Major Books</h6>
                                    <thead>
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Publication Date</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($unavailableMajorBooks as $item)
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->author }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>{{ $item->publication_date }}</td>
                                                <td>{{ $item->quantity }}</td>

                                                <td>
                                                    <span class="badge bg-success">Borrowed by Student</span>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="unvailable-gened-books" role="tabpanel"
                        aria-labelledby="unvailable-gened-books-tab">
                        <div class="table-responsive mt-4 bg-light shadow p-3">

                            <table class="table fs-5" id="dataTableAvailableBook4" width="100%" cellspacing="0">
                                <h6 class="text-dark">List of Unavalable Gened books</h6>
                                <thead>
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Publication Date</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($unavailableGenedBooks as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->author }}</td>
                                            <td>{{ $item->category }}</td>
                                            <td>{{ $item->publication_date }}</td>
                                            <td>{{ $item->quantity }}</td>

                                            <td>
                                                <span class="badge bg-success">Borrowed by Student</span>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    </div>


                </div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="datatable2-to-pick-up" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Books to Pick up</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksToPickUp as $item)
                                    <tr>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>

                                            <form action="{{ route('user.books.destroy') }}" method="post"
                                                class="cancel">
                                                @csrf
                                                @method('DELETE')
                                                <input type="number" name="tIdR" class="hidden" readonly hidden
                                                    value="{{ $item->id }}">
                                                <input type="submit" value="Cancel" class="btn btn-danger ">
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="released" role="tabpanel" aria-labelledby="released-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3" width="100%" cellspacing="0">
                        <table class="table fs-5" id="dataTable3">
                            <h6 class="text-dark">List of Released Books</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Released Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksReleased as $item)
                                    <tr>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable4" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Books to Return</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Released Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksToReturn as $item)
                                    <tr>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td> <span class="badge bg-danger text-white"> {{ $item->status }} </span> </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable5" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Returned Books</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Released Date</th>
                                    <th scope="col">Returned Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksReturned as $item)
                                    <tr>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td>{{ $item->return_date }}</td>
                                        <td> <span class="badge bg-success text-white"> {{ $item->status }} </span> </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
            triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
            })

        //BORROW BOOKS
        $('.borrow').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to borrow this book ?',
                text: " a copy of this book will be reserved ",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, borrow it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        //CANCEL BORROW
        $('.cancel').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to cancel the reservation of this book ?',
                text: " this book transaction will be deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('#dataTable').DataTable();
        $('#datatable2-to-pick-up').DataTable();
        $('#dataTable3').DataTable();
        $('#dataTable4').DataTable();
        $('#dataTable5').DataTable();
        $('#dataTableAvailableBook1').DataTable();
        $('#dataTableAvailableBook2').DataTable();
        $('#dataTableAvailableBook3').DataTable();
        $('#dataTableAvailableBook4').DataTable();

    </script>
@endsection
