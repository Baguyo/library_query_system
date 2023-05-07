
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admi2.0</title>



    <!--Line Awesome Icons-->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
  {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css"> --}}
  

</head>


<body>

        




    <input type="checkbox" name="" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>
                <img src="{{ Storage::url('default/LiBRARYLOGOv2.png') }}" 
                    alt="" class="img-fluid" height="128px" width="128px">
                <span class="fs-5 my-auto">LIBRARY QUERY </span>
            </h2>
        </div>
        
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{route('admin.dashboard')}}" class="{{ request()->is('admin_dashboard') ? 'active' : '' }}"><span class="las la-home"></span><span>Home</span></a>
                </li>
                
                <li>
                    <a href="{{route('admin.student.index')}}" class="{{ request()->is('admin/student*') ? 'active' : '' }}"><span class="las la-robot"></span><span>Students</span></a>
                </li>
                <li>
                    <a href="{{route('admin.books.index')}}" class="{{ request()->is('admin/books*') ? 'active' : '' }}"><span class="las la-robot"></span><span>Books</span></a>
                </li>
                <li>
                    <a href="{{route('admin.profile.edit')}}" class="{{ request()->is('admin/profile*') ? 'active' : '' }}"><span class="las la-robot"></span><span>Profile</span></a>
                </li>
                {{-- <li>
                    <a href="#" onclick="event.preventDefault();"><span class="las la-plus"></span><span>Admin</span></a>
                </li> --}}
                <li id="logout">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><span class="las la-sign-out-alt"></span><span>Logout</span></a>
                </li>
                <form action="{{ route('logout') }}" class="d-none" method="POST" id="logout-form">
                    @csrf
                </form>

            </ul>
        </div>
    </div>

    <div class="main-content">
        <section>

            <h4><label for="nav-toggle" class="fs-2">
                    <span class="las la-bars"></span>
            </h4>



            <div class="dark-mode">
                <span class="las la-sun active"></span>
                <span class="las la-moon"></span>
            </div>

            <div class="user-wrapper">
                
                <div class="d-flex">
                    <p class="my-auto mr-5"> {{ Auth::user()->name }}</p>
                    

                    <img src="{{ Storage::url('default/LiBRARYLOGOv2.png') }}" 
                    alt="" class="img-fluid" height="64px" width="64px">
                    
                    
                </div>
                
                
            </div>

        </section>

        <main class="card-container fs-2">
            
                @yield('content')
            
            
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> --}}
    
    


    <script type="text/javascript">
      document.getElementById("image").onchange = function(){
          document.getElementById("form").submit();
      };
    </script>

    <script>
        const themeToggler = document.querySelector(".dark-mode");
        themeToggler.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme-variables');

            themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
            themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
        })
    </script>

    <script>
        $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>


</body>

</html>