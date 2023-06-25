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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class=" text-danger fs-5">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.books.import') }}" method="POST" enctype="multipart/form-data" class="row mb-3">
        @csrf
        <div class="col">
            <input type="file" name="file" class="form-control">
        </div>
        <div class="col" style="margin-top: -7px">
            <button class="btn btn-primary" type="submit">Import Book Data</button>
        </div>

    </form>

    <div class="card">

        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $status === 'available' ? 'active' : '' }} text-primary fs-5" id="home-tab"
                        data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home"
                        aria-selected="true">Available Books <span class="badge bg-primary"> {{ $totalBooks }} </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $status === 'pickUp' ? 'active' : '' }} text-warning fs-5" id="profile-tab"
                        data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                        aria-selected="false">
                        @if ($isNewBooksToRelease)
                            <sup>
                                <span class="badge bg-dark text-warning">New!</span>
                            </sup>
                        @endif
                        Books to release <span class="badge bg-warning">
                            {{ $booksToRelease->count() }} </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $status === 'released' ? 'active' : '' }} text-info fs-5" id="released-tab"
                        data-bs-toggle="tab" data-bs-target="#released" type="button" role="tab"
                        aria-controls="released" aria-selected="false">Books released <span class="badge bg-info">
                            {{ $booksReleased->count() }}
                        </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $status === 'toReturn' ? 'active' : '' }} text-danger fs-5"
                        id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab"
                        aria-controls="messages" aria-selected="false">Books to return <span class="badge bg-danger">
                            {{ $booksToReturn->count() }}
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
                <div class="tab-pane {{ $status === 'available' ? 'active' : '' }}" id="home" role="tabpanel"
                    aria-labelledby="home-tab">


                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table display fs-5" id="dataTable" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Available Books</h6>
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
                            <tfoot>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Publication</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @forelse ($books as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->author }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->publication_date }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>


                                            <div class="">
                                                <button type="button" bTitle="{{ $item->name }}"
                                                    bData="{{ $item->name }}+{{ $item->author }}+{{ $item->category }}+{{ $item->publication_date }}"
                                                    class="btn btn-primary btn-sm view-book" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop2">
                                                    View
                                                </button>


                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane {{ $status === 'pickUp' ? 'active' : '' }}" id="profile" role="tabpanel"
                    aria-labelledby="profile-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable2" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Books to Release</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Control #</th>
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
                                        <td>{{ $item->book->isbn }}</td>
                                        <td>{{ $item->book->control_number }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td> <span class="badge bg-warning text-dark"> {{ $item->status }} </span> </td>
                                        <td>
                                            <form action="{{ route('admin.books.release') }}" method="post"
                                                class="release">
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
                <div class="tab-pane {{ $status === 'released' ? 'active' : '' }}" id="released" role="tabpanel"
                    aria-labelledby="released-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable3" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Released Books</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Control #</th>
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
                                        <td>{{ $item->book->isbn }}</td>
                                        <td>{{ $item->book->control_number }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td> <span class="badge bg-info text-dark"> {{ $item->status }} </span> </td>
                                        <td>
                                            <form action="{{ route('admin.books.return') }}" method="post"
                                                class="return">
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
                <div class="tab-pane {{ $status === 'toReturn' ? 'active' : '' }}" id="messages" role="tabpanel"
                    aria-labelledby="messages-tab">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable4" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Books to return</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Control #</th>
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
                                        <td>{{ $item->book->isbn }}</td>
                                        <td>{{ $item->book->control_number }}</td>
                                        <td>{{ $item->book->publication_date }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>{{ $item->release_date }}</td>
                                        <td> <span class="badge bg-danger"> {{ $item->status }} </span> </td>
                                        <td>
                                            <form action="{{ route('admin.books.return') }}" method="post"
                                                class="return">
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
                        <table class="table fs-5" id="dataTable5" width="100%" cellspacing="0">
                            <h6 class="text-dark">List of Returned Books</h6>
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Control #</th>
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
                                        <td>{{ $item->book->isbn }}</td>
                                        <td>{{ $item->book->control_number }}</td>
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


    {{-- SHOW BOOKS TRANSCATION --}}
    <!-- Modal -->
    <div class="modal modal-lg fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title text-dark" id="staticBackdropLabel">BOOK TRANSCATION</h5>
                    <button type="button" class="btn-close close-transaction" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <div class="book-title text-dark">

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
                            <tbody class="tbodyTrans">

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


    {{-- VIEW BOOK --}}
    <div class="modal modal-xl fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="staticBackdropLabel">BOOK INFORMATION</h5>
                    <button type="button" class="btn-close close-view-book" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive mt-3 bg-light shadow p-3">
                        <div class="book-title-view text-dark">

                        </div>
                        <table class="table fs-5" id="dataTable7">
                            <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Control #</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyView">


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-view-book"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteFromModal(event) {

            let form = event.parentNode;
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
                    form.submit();
                }
            })
        }


        //TODO
        function viewTransaction(identifier) {

            var rowData;

            $(".book-title").html("<p>" + identifier.getAttribute('bName') + "</p> <p> ISBN:" + identifier.getAttribute(
                'isbn') + "</p> <p> Control Number:" + identifier.getAttribute('ctrlNum') + " </p>");

            $.ajax({
                type: "GET",
                url: `{{ route('admin.books.ajaxView') }}`,
                data: {
                    bookId: identifier.getAttribute('bId')
                },
                dataType: "json",
                success: function(response) {

                    response.forEach(element => {

                        rowData += "<tr>";
                        rowData += "<td>" + element.user.name + "</td>";

                        if (element.status === "returned") {
                            rowData += "<td><div class='badge bg-success'>" + element.status +
                                "</div></td>";
                        } else if (element.status === 'to release') {
                            rowData += "<td><div class='badge bg-warning'>" + element.status +
                                "</div></td>";
                        } else if (element.status === 'released') {
                            rowData += "<td><div class='badge bg-info'>" + element.status +
                                "</div></td>";
                        } else if (element.status === 'to return') {
                            rowData += "<td><div class='badge bg-danger'>" + element.status +
                                "</div></td>";
                        }

                        rowData += "<td>" + element.reference + "</td>";
                        rowData += "<td>" + element.release_date + "</td>";
                        rowData += "<td>" + element.return_date + "</td>";
                        rowData += "</tr>";
                    });
                    $('.tbodyTrans').html(rowData);
                    // $('.modal-body').html("<h1>"+bookId +"</h1>");
                    $('#dataTable6').DataTable();
                }

            });

            $("#staticBackdrop").modal('show');

            $('#staticBackdrop').css("z-index", 400000);
        }
    </script>
    <script type="module">


        

        //SHOW BOOK INFORMATION
        $('.view-book').click(function (e) { 
            
            var bookTitleView = $(this).attr('bTitle');
            var bookDataView = $(this).attr('bData');
            $('.book-title-view').html(
                        "<h6> Book '" + bookTitleView + "' Information</h6>"
                    );
                    var rowData;
            $.ajax({
                type: "GET",
                url: `{{ route('admin.books.ajaxViewBookInfo') }}`,
                data: {bookData: bookDataView},
                dataType: "json",
                success: function (response) {
                    
                    
                    response.forEach(element => {
                        
                        let urlToEdit = "{{ route('admin.books.edit', ['book' => 10000000000000]) }}";
                        urlToEdit = urlToEdit.replace('10000000000000', element.id);

                        let urlTodelete = "{{ route('admin.books.destroy', ['book'=>1000000000000]) }}";
                        urlTodelete = urlTodelete.replace('1000000000000', element.id);

                        rowData +=  "<tr>";
                        rowData += "<td>"+ element.name  +"</td>";
                        rowData += "<td>"+ element.author+"</td>";
                        rowData += "<td>"+ element.category+"</td>";
                        rowData += "<td>"+ element.isbn+"</td>";
                        rowData += "<td>"+ element.control_number+"</td>";
                        rowData += "<td>"+ element.publication_date+"</td>";
                        rowData += "<td>"+ 
                            `<div type='button' onclick=viewTransaction(this) bName='${element.name}' bId='${element.id}' isbn='${element.isbn}' ctrlNum='${element.control_number}' class='btn btn-warning btn-sm view-transac mb-2'>view transaction  </div>` 
                            +`                                            <div class="d-flex justify-content-between">
                                                <a href="${urlToEdit}"
                                                    class="btn btn-sm btn-primary">Edit</a>
                                                <form method="post" action="${urlTodelete}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="button" value="Delete" class="btn btn-sm btn-danger" onclick="deleteFromModal(this)">
                                                </form>
                                            </div>`
                            +"</td>";
                        rowData += "</tr>";                        
                    });
                    $('.tbodyView').html(rowData);
            //         
                    
                    $('#dataTable7').DataTable({
                        'responsive':true
                    });   
                    
                    
                }
                 
            });

        });

        //SHOW TRANSACTION
        var viewTransacBtn = document.querySelectorAll('.viewTransac');
        console.log(viewTransacBtn);
        

        
        

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

        

        //MODAL CLOSE BUTTON
        $('.close-transaction').click(function (e) { 
            $('#dataTable6').DataTable().clear().destroy();
            $('.book-title').html('');
        });

        $('.close-view-book').click(function (e) { 
            $('#dataTable7').DataTable().clear().destroy();
        });
        

        $('#dataTable').DataTable({
            'responsive':true,
            dom: 'Bfrtip',
            buttons: [
                {
                extend: 'pageLength'
                },
                {
                extend: 'print',
                exportOptions: {
                    columns: [ 0,1,2,3,4 ]
                    },            
                }
                
            ]
        });


        $('#dataTable2').DataTable({
            'responsive':true,
        });
        $('#dataTable3').DataTable({
            'responsive':true,
        });
        $('#dataTable4').DataTable({
            'responsive':true,
        });
        $('#dataTable5').DataTable({
            'responsive':true,
        });


        
        
       
        
    </script>
@endsection
