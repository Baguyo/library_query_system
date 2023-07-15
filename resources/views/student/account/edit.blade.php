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
                    Edit Account
                </h1>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-danger fs-5">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form action="{{ route('user.account.update', ['user' => $user->id]) }}" method="post">
                    @method('PUT')
                    @csrf

                    <div class="mb-3">
                        <label for="" class="form-label ">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ old('email', $user->email) }}" aria-describedby="emailHelpId">

                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">New Password</label>
                        <input type="password" class="form-control " name="password" id="" placeholder="">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label ">Retype Password</label>
                        <input type="password" class="form-control " name="password_confirmation" id=""
                            placeholder="">
                    </div>



                    <input type="submit" value="Update Account" class="btn btn-primary ">

                </form>
            </div>
        </div>

    </div>
@endsection
