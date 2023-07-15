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


                <form action="{{ route('admin.student.update', ['student' => $student->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="" class="form-label ">Name</label>
                        <input type="text" class="form-control " value="{{ old('name', $student->user->name) }}"
                            name="name" aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Email</label>
                        <input type="email" class="form-control " value="{{ old('email', $student->user->email) }}"
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
                        <label for="course" class="form-label ">Course</label>

                        <div class="">
                            <select class="form-select @error('course') is-invalid @enderror" name="course" id="course">
                                <option value="" selected>Select one</option>
                                <option value="BSIT" {{ old('course', $student->course) === 'BSIT' ? 'selected' : '' }}>
                                    BSIT</option>
                                <option value="BSCS" {{ old('course', $student->course) === 'BSCS' ? 'selected' : '' }}>
                                    BSCS</option>
                                <option value="BSECE"{{ old('course', $student->course) === 'BSECE' ? 'selected' : '' }}>
                                    BSECE</option>
                            </select>

                            @error('course')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Student Number</label>
                        <input type="number" class="form-control "
                            value="{{ old('student_number', $student->student_number) }}" name="student number"
                            aria-describedby="helpId" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label ">Year</label>

                        <div class="">
                            <select class="form-select form-select @error('course') is-invalid @enderror" name="year"
                                id="year">

                                @if ($student->course == 'BSECE')
                                    <option value=" ">-- SELECT --</option>
                                    <option value="1" {{ old('course', $student->year) == 1 ? 'selected' : '' }}>1st
                                        year</option>
                                    <option value="2" {{ old('course', $student->year) == 2 ? 'selected' : '' }}>2nd
                                        year</option>
                                    <option value="3" {{ old('course', $student->year) == 3 ? 'selected' : '' }}>3rd
                                        year</option>
                                    <option value="4" {{ old('course', $student->year) == 4 ? 'selected' : '' }}>4th
                                        year</option>
                                    <option value="5" {{ old('course', $student->year) == 5 ? 'selected' : '' }}>5th
                                        year</option>
                                @else
                                    <option value=" ">-- SELECT --</option>
                                    <option value="1" {{ old('course', $student->year) == 1 ? 'selected' : '' }}>1st
                                        year</option>
                                    <option value="2" {{ old('course', $student->year) == 2 ? 'selected' : '' }}>2nd
                                        year</option>
                                    <option value="3" {{ old('course', $student->year) == 3 ? 'selected' : '' }}>3rd
                                        year</option>
                                    <option value="4" {{ old('course', $student->year) == 4 ? 'selected' : '' }}>4th
                                        year</option>
                                @endif

                            </select>

                            @error('year')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Address</label>
                        <textarea class="form-control " name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                    </div>

                    <input type="submit" value="Update Student" class="btn btn-primary ">

                </form>
            </div>
        </div>

    </div>

    <script>
        $('#course').change(function(e) {
                    $('#year').html();
                    if ($('#course').val() == 'BSECE') {
                        $('#year').html(
                            "<option value='1' selected> -- SELECT -- </option>" +
                            "<option value='1'>1st year</option>" +
                            "<option value='2'>2nd year</option>" +
                            "<option value='3'>3rd year</option>" +
                            "<option value='4'>4th year</option>" +
                            "<option value='5'>5th year</option>"
                        )
                    } else {
                        $('#year').html(
                            "<option value='1' selected> -- SELECT -- </option>" +
                            "<option value='1'>1st year</option>" +
                            "<option value='2'>2nd year</option>" +
                            "<option value='3'>3rd year</option>" +
                            "<option value='4'>4th year</option>"
                        )
                    }
                });
    </script>
@endsection
