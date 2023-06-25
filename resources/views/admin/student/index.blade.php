@extends('admin.layouts.dash')

@section('content')

    @if (session('success'))
        <p class="alert alert-success ">
            {{ Session::get('success') }}
        </p>
    @endif

    <a href="{{route('admin.student.create')}}" class="btn  btn-primary  mt-4">
        Add student
    </a>

    <div class="table-responsive mt-4 bg-light shadow p-4">
        
        <table class="table fs-5" id="dataTable" width="100%" cellspacing="0">
            <h6 class="text-dark">List of Students</h6>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Email</th>
                    <th scope="col">Student Number</th>
                    <th scope="col">Year</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $item)
                
                    <tr>
                        <td>{{$item->user->name}}</td>
                        <td>
                            @if ($item->img_path)
                            <img src="{{ Storage::url($item->img_path) }}" 
                            alt="" class="img-fluid" height="128px" width="128px">
                            @else
                                <span class="badge bg-secondary">No image</span>
                            @endif
                        </td>
                        <td>{{$item->user->email}}</td>
                        <td>{{$item->student_number}}</td>
                        <td>{{ $item->year }}</td>
                        <td>{{$item->address}}</td>
                        <td> <a href="{{ route('admin.student.edit', ['student'=>$item->id]) }}" class="btn btn-primary">Edit</a> </td>
                    </tr>
                
                @empty
                
                    
                @endforelse
            </tbody>
        </table>
    </div>

    
    <script type="module">
        $('#dataTable').DataTable({
            'responsive': true,
        });
    </script>
    
@endsection