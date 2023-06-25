@extends('admin.layouts.dash')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h1>
                    Add Book
                </h1>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class=" text-danger fs-5">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('admin.books.store') }}" method="post" class="create-book">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label ">Title</label>
                        <input type="text" class="form-control " value="{{old('name')}}"
                        name="name" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Author</label>
                        <input type="text" class="form-control "  value="{{old('author')}}"
                        name="author" aria-describedby="emailHelpId">

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Category</label>

                        
                            <select class="form-select" name="category" id="">
                                <option value="" selected>--Select--</option>
                                <option value="BSIT" {{ (old('category') === 'BSIT') ? 'selected' : '' }}>BSIT</option>
                                <option value="BSCS" {{ (old('category') === 'BSCS') ? 'selected' : '' }}>BSCS</option>
                                <option value="BSECE"{{ (old('category') === 'BSECE') ? 'selected' : '' }}>BSECE</option>
                                <option value="GENED"{{ (old('category') === 'GENED') ? 'selected' : '' }}>GENED</option>
                            </select>
                        

                    </div>

                    <div class="mb-3">
                      <label for="" class="form-label">ISBN</label>
                      <input type="text"
                        class="form-control" name="isbn" id="" aria-describedby="helpId" placeholder="">
                    </div>

                    {{-- <div class="mb-3">
                        <label for="" class="form-label ">Quantity</label>
                        <input type="number" class="form-control "  value="{{old('quantity')}}"
                        name="quantity" aria-describedby="emailHelpId">
                    </div> --}}

                    

                    <div class="mb-3">
                        <label for="" class="form-label ">Publication Date</label>
                        <input type="date" class="form-control "  value="{{old('publication_date')}}"
                        name="publication date" aria-describedby="emailHelpId">

                    </div>
                    


                    <input type="submit" value="Add Book" class="btn btn-primary ">

                </form>
            </div>
        </div>

    </div>

    <script type="module">
        $('.create-book').submit(function (e) { 
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to add this book ?',
                text: " Control Number is auto generated and not changeable ",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, create it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        });

    </script>
@endsection
