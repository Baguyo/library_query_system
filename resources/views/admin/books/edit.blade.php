@extends('admin.layouts.dash')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h1>
                    Edit Book
                </h1>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="fs-5 text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('admin.books.update', ['book'=>$book->id]) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label ">Name</label>
                        <input type="text" class="form-control " value="{{old('name',$book->name)}}"
                        name="name" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Author</label>
                        <input type="text" class="form-control "  value="{{old('author',$book->author)}}"
                        name="author" aria-describedby="emailHelpId">

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Category</label>
                        <input type="text" class="form-control "  value="{{old('category',$book->category)}}"
                        name="category" aria-describedby="emailHelpId">

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Quantity</label>
                        <input type="number" class="form-control "  value="{{old('quantity',$book->quantity)}}"
                        name="quantity" aria-describedby="emailHelpId">

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Publication Date</label>
                        <input type="date" class="form-control "  value="{{old('publication_date',$book->publication_date)}}"
                        name="publication date" aria-describedby="emailHelpId">

                    </div>
                    


                    <input type="submit" value="Edit Book" class="btn btn-primary ">

                </form>
            </div>
        </div>

    </div>
@endsection
