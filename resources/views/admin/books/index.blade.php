@extends('admin.layouts.dash')

@section('content')
    @if (session('success'))
        <p class="alert alert-success fs-5">
            {{ Session::get('success') }}
        </p>
    @endif


    <a href="{{ route('admin.books.create') }}" class="btn btn-primary mt-3 mb-4">
        Add Book
    </a>

    <div class="card">

        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($status === "available") ? 'active' :'' }} text-primary fs-5" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                        aria-selected="true">Available Books <span class="badge bg-primary"> {{ $books->count() }} </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($status === "pickUp") ? 'active' :'' }} text-warning fs-5" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">
                        @if ($isNewBooksToRelease)
                            <sup>
                                <span class="badge bg-dark text-warning">New!</span>
                            </sup>
                        @endif
                        Books to release <span class="badge bg-warning">
                            {{ $booksToRelease->count() }} </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($status === "released") ? 'active' :'' }} text-info fs-5" id="released-tab" data-bs-toggle="tab"
                        data-bs-target="#released" type="button" role="tab" aria-controls="released"
                        aria-selected="false">Books released <span class="badge bg-info"> {{ $booksReleased->count() }}
                        </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($status === "toReturn") ? 'active' :'' }} text-danger fs-5" id="messages-tab" data-bs-toggle="tab"
                        data-bs-target="#messages" type="button" role="tab" aria-controls="messages"
                        aria-selected="false">Books to return <span class="badge bg-danger"> {{ $booksToReturn->count() }}
                        </span></button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-success fs-5" id="settings-tab" data-bs-toggle="tab"
                        data-bs-target="#settings" type="button" role="tab" aria-controls="settings"
                        aria-selected="false">Returned Books <span
                            class="badge bg-success">{{ $booksReturned->count() }}</span></button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane {{ ($status === "available") ? 'active' :'' }}" id="home" role="tabpanel" aria-labelledby="home-tab">

                    {{-- <input type="text" list="cars" />
                    <datalist id="cars">
                        <option>Volvo</option>
                        <option>Saab</option>
                        <option>Mercedes</option>
                        <option>Audi</option>
                    </datalist> --}}
                    {{-- https://www.jsdelivr.com/package/npm/sweetalert2 --}}

                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Copies to release</th>
                                    <th scope="col">Copies released</th>
                                    <th scope="col">Copies to return</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($books as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->author }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->to_release_count }}</td>
                                        <td>{{ $item->release_count }}</td>
                                        <td>{{ $item->to_return_count }}</td>
                                        <td>{{ $item->publication_date }}</td>
                                        <td>
                                            {{-- <a href="#" class="btn btn-sm btn-warning">
                                                view transaction
                                            </a> --}}
                                            <button type="button" bTitle="{{ $item->name }}" bId="{{ $item->id }}"
                                                class="btn btn-warning btn-sm trans-show mb-2" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                view transaction
                                            </button>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('admin.books.edit', ['book' => $item->id]) }}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form method="post" class="delete" action="{{ route('admin.books.destroy', ['book'=>$item->id]) }}">
                                                    @method('delete')
                                                    @csrf
                                                    {{-- <input type="number" name="bId" id="" value="{{$item->id}}" disabled hidden> --}}
                                                    <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane {{ ($status === "pickUp") ? 'active' :'' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable2">
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksToRelease as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td> <span class="badge bg-warning text-dark"> {{ $item->status }} </span> </td>
                                        <td>
                                            <form action="{{ route('admin.books.release') }}" method="post" class="release">
                                                @csrf
                                                <input type="number" name="tIdR" class="hidden" readonly hidden
                                                    value="{{ $item->id }}">
                                                <input type="submit" value="Release" class="btn btn-primary ">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane {{ ($status === "released") ? 'active' :'' }}" id="released" role="tabpanel" aria-labelledby="released-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable3">
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Released Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksReleased as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td> <span class="badge bg-info text-dark"> {{ $item->status }} </span> </td>
                                        <td>
                                            <form action="{{ route('admin.books.return') }}" method="post" class="return">
                                                @csrf
                                                <input type="number" name="tIdR" class="d-none" readonly hidden
                                                    value="{{ $item->id }}">
                                                <input type="submit" value="Return" class="btn btn-success ">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane {{ ($status === "toReturn") ? 'active' :'' }}" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable4">

                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Released Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booksToReturn as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->book->name }}</td>
                                        <td>{{ $item->book->author }}</td>
                                        <td>{{ $item->book->category }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td> <span class="badge bg-danger"> {{ $item->status }} </span> </td>
                                        <td>
                                            <form action="{{ route('admin.books.return') }}" method="post" class="return">
                                                @csrf
                                                <input type="text" name="status" class="hidden" readonly hidden
                                                    value="toReturn">                                                
                                                <input type="number" name="tIdR" class="hidden" readonly hidden
                                                    value="{{ $item->id }}">
                                                <input type="submit" value="Return" class="btn btn-success ">
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable5">
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Name</th>
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
                                        <td>{{ $item->user->name }}</td>
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


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal modal-xl fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">BOOK TRANSCATION</h5>
                    <button type="button" class="btn-close close-transaction" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <div class="book-title">

                        </div>
                        <table class="table fs-5" id="dataTable6">
                            <thead class="head">
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Released Date</th>
                                    <th scope="col">Returned Date</th>

                                </tr>
                            </thead>
                            <tbody class="tbody">

                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-transaction"
                        data-bs-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>

    <script type="module">

        $('.trans-show').click(function (e) { 
            var bookId = $(this).attr('bId');
            var bookTitle = $(this).attr('bTitle');
            $('.book-title').html(
                        "<h6> Book '" + bookTitle + "' Transactions</h6>"
                    );
            var rowData;
            $.ajax({
                type: "GET",
                url: `{{ route('admin.books.ajaxView') }}`,
                data: {bookId: bookId},
                dataType: "json",
                success: function (response) {
                    console.log(response)


                    // TODO
                    // PASS BOOK TITLE DYNAMICALLY


                    
                    response.forEach(element => {
                        console.log(element.id);
                        rowData +=  "<tr>";
                        rowData += "<td>"+ element.user.name  +"</td>";
                        
                        if(element.status === "returned"){
                            rowData += "<td><div class='badge bg-success'>"+ element.status +"</div></td>";
                        }else if(element.status === 'to release'){
                            rowData += "<td><div class='badge bg-warning'>"+ element.status +"</div></td>";
                        }else if(element.status === 'released'){
                            rowData += "<td><div class='badge bg-info'>"+ element.status +"</div></td>";
                        }else if(element.status === 'to return'){
                            rowData += "<td><div class='badge bg-danger'>"+ element.status +"</div></td>";
                        }

                        rowData += "<td>"+ element.reference+"</td>";
                        rowData += "<td>"+ element.release_date+"</td>";
                        rowData += "<td>"+ element.return_date+"</td>";
                        rowData += "</tr>";
                    });
                    $('.tbody').html(rowData);
            // $('.modal-body').html("<h1>"+bookId +"</h1>");
                    $('#dataTable6').DataTable();   
                }
                
                
            });
            
        });

        //DELETE BOOK
        $('.delete').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this book ?',
                text: " All data associated to this book will also be deleted ! ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        //RELEASE BOOK
        $('.release').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to release this book ?',
                text: " It will mark this book transaction as released ",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, release it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        //RETURN BOOK
        $('.return').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to return this book ?',
                text: " It will mark this book transaction as returned ",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, return it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

        $('.close-transaction').click(function (e) { 
            // $('.tbody').html('');
            // var table = $('#dataTable6').DataTable();
            // table.empty();
            $('#dataTable6').DataTable().clear().destroy();
        });

        $('#dataTable').DataTable();
        $('#dataTable2').DataTable();
        $('#dataTable3').DataTable();
        $('#dataTable4').DataTable();
        $('#dataTable5').DataTable();
        
    </script>
@endsection
