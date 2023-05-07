@extends('student.layouts.dash')

@section('content')

    <div class="row mt-2">
        
            <div class="col-lg-4 mb-5">
                <div class="card ">
                    <div class="card-header bg-primary text-white">
                        <h3>Available Books</h3>
                    </div>
                    <div class="card-body ">
                        <p class="text-center fs-2">
                            <span class="badge bg-primary">{{$books}}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h3>Books to pick up</h3>
                    </div>
                    <div class="card-body ">
                        <p class="text-center fs-2">
                            <span class="badge bg-warning">{{$booksToPickUp}}</span>
                        </p>
                    </div>
                </div> 
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h3>Books released</h3>
                    </div>
                    <div class="card-body ">
                        <p class="text-center fs-2">
                            <span class="badge bg-info">{{$booksReleased}}</span>
                        </p>
                    </div>
                </div> 
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h3>Books to return</h3>
                    </div>
                    <div class="card-body ">
                        <p class="text-center fs-2">
                            <span class="badge bg-danger">{{$booksToReturn}}</span>
                        </p>
                    </div>
                </div> 
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h3>Returned Books</h3>
                    </div>
                    <div class="card-body ">
                        <p class="text-center fs-2">
                            <span class="badge bg-success">{{$booksReturned}}</span>
                        </p>
                    </div>
                </div> 
            </div>
        
    </div>
   
@endsection
