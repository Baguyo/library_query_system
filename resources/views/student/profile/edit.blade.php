@extends('student.layouts.dash')

@section('content')

    @if (session('success'))
        <p class="alert alert-success ">
            {{ Session::get('success') }}
        </p>
    @endif
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h1>
                    Edit Profile
                </h1>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class=" text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('user.profile.update', ['user' => Auth()->user()->id]) }}" method="post" enctype="multipart/form-data" >
                    @csrf
                    @method('PUT')

                    @if (Auth()->user()->student->img_path)
                        <img src="{{ Storage::url(Auth()->user()->student->img_path) }}" 
                        alt="" class="img-fluid" height="128px" width="128px">
                    @endif

                    <div class="mb-3">
                      <label for="" class="form-label ">Image</label>
                      <input type="file" class="form-control" name="avatar" id="" placeholder="" aria-describedby="fileHelpId">
                    </div>

                    

                    <div class="mb-3">
                        <label for="" class="form-label ">Student Number</label>
                        <input type="number" class="form-control  disabled" @disabled(true)
                            value="{{ $user->student->student_number }}" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Course</label>
                        <input type="text" class="form-control  disabled" @disabled(true)
                            value="{{ $user->student->course }}" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Year </label>
                        <input type="number" class="form-control  disabled" @disabled(true)
                            value="{{ $user->student->year }}" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Address</label>
                        <textarea class="form-control " name="address" rows="3">{{ old('address', $user->student->address) }}</textarea>
                    </div>

                    <input type="submit" value="Update" class="btn btn-primary">

                </form>
            </div>
        </div>

    </div>
@endsection
