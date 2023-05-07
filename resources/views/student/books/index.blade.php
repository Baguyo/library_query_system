@extends('student.layouts.dash')

@section('content')
    @if (session('success'))
        <p class="alert alert-success ">
            {{ Session::get('success') }}
        </p>
    @endif

    

    <div class="card">

        @if (!$imgStatus)
            <div class="card-header">
                <div class="alert alert-danger" role="alert">
                    <h1> Your image not been set. You're unable to borrow a book. </h1>
                </div>
                    
            </div>    
        @endif

        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-primary fs-5" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Books to borrow <span class="badge bg-primary"> {{$books->count()}} </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-warning fs-5" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">Books to pick up <span class="badge bg-warning">{{ $booksToPickUp->count() }}</span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-info fs-5" id="released-tab" data-bs-toggle="tab" data-bs-target="#released"
                        type="button" role="tab" aria-controls="released" aria-selected="false">Books released <span class="badge bg-info"> {{$booksReleased->count()}} </span> </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-danger fs-5" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages"
                        type="button" role="tab" aria-controls="messages" aria-selected="false">Books to return <span class="badge bg-danger"> {{$booksToReturn->count()}} </span> </button>
                </li>
                
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-success fs-5" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                        type="button" role="tab" aria-controls="settings" aria-selected="false">Returned Books <span class="badge bg-success"> {{$booksReturned->count()}} </span></button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Quantity</th>
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
                                        <td>{{  $item->quantity  - ($item->to_release_count + $item->release_count + $item->to_return_count)   }}</td>
                                        <td>{{ $item->publication_date }}</td>
                                        <td>
                                            @if ($item->quantity == 0)
                                                <span class="badge bg-danger">Out of stock</span>
                                            @else
                                                @if ($imgStatus)
                                                <form action="{{ route('user.books') }}" method="post">
                                                    @csrf
                                                    <input type="number" name="bId" class="hidden" readonly hidden
                                                        value="{{ $item->id }}">
                                                    <input type="submit" value="Borrow" class="btn btn-primary">
                                                </form>    
                                                @else
                                                    <button class="btn " disabled>
                                                        Unable to borrow
                                                    </button>
                                                @endif
                                                
                                            @endif
                
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable2">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Publication Date</th>
                                    <th scope="col">Release Date</th>
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
                                        <td>{{ $item->release_date }}</td>
                                        <td>
                                            <form action="" method="post">
                                                @csrf
                                                <form action="{{ route('user.books.destroy') }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="number" name="tIdR" class="hidden" readonly hidden
                                                        value="{{ $item->id }}">
                                                    <input type="submit" value="Cancel" class="btn btn-danger ">
                                                </form>
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
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable3">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
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
                                    <td>{{$item->book->name}}</td>
                                    <td>{{$item->book->author}}</td>
                                    <td>{{$item->book->category}}</td>
                                    <td>{{$item->book->publication_date}}</td>
                                    <td>{{$item->reference}}</td>
                                    <td>{{$item->release_date}}</td>
                                   </tr>
                               @empty
                                   
                               @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable4">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
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
                                    <td>{{$item->book->name}}</td>
                                    <td>{{$item->book->author}}</td>
                                    <td>{{$item->book->category}}</td>
                                    <td>{{$item->book->publication_date}}</td>
                                    <td>{{$item->reference}}</td>
                                    <td>{{$item->release_date}}</td>
                                    <td> <span class="badge bg-danger text-white"> {{$item->status}} </span> </td>
                                   </tr>
                               @empty
                                   
                               @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="table-responsive mt-4 bg-light shadow p-3">
                        <table class="table fs-5" id="dataTable5">
                            <thead>
                                <tr>
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
                                    <td>{{$item->book->name}}</td>
                                    <td>{{$item->book->author}}</td>
                                    <td>{{$item->book->category}}</td>
                                    <td>{{$item->book->publication_date}}</td>
                                    <td>{{$item->reference}}</td>
                                    <td>{{$item->release_date}}</td>
                                    <td>{{$item->return_date}}</td>
                                    <td> <span class="badge bg-success text-white"> {{$item->status}} </span> </td>
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
        $('#dataTable').DataTable();
        $('#dataTable2').DataTable();
        $('#dataTable3').DataTable();
        $('#dataTable4').DataTable();
        $('#dataTable5').DataTable();
    </script>
@endsection
