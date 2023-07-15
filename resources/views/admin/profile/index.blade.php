@extends('admin.layouts.dash')

@section('content')

    @if (session('success'))
        <p class="alert alert-success ">
            {{ Session::get('success') }}
        </p>
    @endif

    <a href="{{route('admin.add.create')}}" class="btn  btn-primary  mt-4">
        Add Admin
    </a>

    <div class="table-responsive mt-4 bg-light shadow p-4">
        
        <table class="table fs-5" id="dataTable" width="100%" cellspacing="0">
            <h6 class="text-dark">List of Administrator</h6>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($admin as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->created_at}}</td>
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