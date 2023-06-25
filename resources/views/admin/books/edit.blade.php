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
                        <select class="form-select" name="category" id="">
                            <option value="" selected>--Select--</option>
                            <option value="BSIT" {{ (old('category',$book->category) === 'BSIT') ? 'selected' : '' }}>BSIT</option>
                            <option value="BSCS" {{ (old('category',$book->category) === 'BSCS') ? 'selected' : '' }}>BSCS</option>
                            <option value="BSECE" {{(old('category',$book->category) === 'BSECE') ? 'selected' : '' }}>BSECE</option>
                            <option value="GENED" {{(old('category',$book->category) === 'GENED') ? 'selected' : '' }}>GENED</option>
                            
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">ISBN</label>
                        <input type="text" class="form-control "  value="{{old('isbn',$book->isbn)}}"
                        name="isbn" aria-describedby="emailHelpId">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Control Number / it is not changeable</label>
                        <input type="text" class="form-control "  value="{{$book->control_number}}" @disabled(true)
                        name="" aria-describedby="emailHelpId">                        
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
