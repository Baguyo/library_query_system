@extends('admin.layouts.dash')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h1>
                    Edit student
                </h1>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class=" fs-5 text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('admin.student.update', ['student'=>$student->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="" class="form-label ">Name</label>
                        <input type="text" class="form-control " value="{{old('name',$student->user->name)}}"
                        name="name" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Email</label>
                        <input type="email" class="form-control "  value="{{old('email',$student->user->email)}}"
                        name="email" aria-describedby="emailHelpId">

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Password</label>
                        <input type="password" class="form-control " name="password" id="" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Retype Password</label>
                        <input type="password" class="form-control " name="password_confirmation" id=""
                            placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Student Number</label>
                        <input type="number" class="form-control " value="{{old('student_number',$student->student_number)}}"
                        name="student number" aria-describedby="helpId"
                            placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Year </label>
                        <input type="number" class="form-control " value="{{old('year',$student->year)}}"
                        name="year" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Address</label>
                        <textarea class="form-control " name="address" rows="3">{{old('address',$student->address)}}</textarea>
                    </div>

                    <input type="submit" value="Update Student" class="btn btn-primary ">

                </form>
            </div>
        </div>

    </div>
@endsection
