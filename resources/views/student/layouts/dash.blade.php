
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FbcLibrary</title>
    

    {{-- icon --}}
    <link rel="icon" href="{{ Storage::url('default/LIBRARYLOGOv2.png') }}">

    {{-- SWEET ALERT --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

    <!--Line Awesome Icons-->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

</head>


<body class="{{ $theme == 'dark' ? 'dark-theme-variables' : ''}}">

            






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
                    <a href="{{ route('user.dashboard') }}" class="{{ request()->is('user') ? 'active' : '' }}"><span class="las la-home"></span><span>Home</span></a>
                </li>
                
                <li>
                    <a href="{{route('user.profile.edit', ['user'=>Auth()->user()->id])}}" class="{{ request()->is('user/profile*') ? 'active' : '' }}"><span class="las la-user-circle"></span><span>Profile</span></a>
                </li>
                <li>
                    <a href="{{ route('user.books') }}" class="{{ request()->is('user/books*') ? 'active' : '' }}"><span class="las la-book"></span><span>Books</span></a>
                </li>
                <!--<li>
                    <a href="add-admin.php"><span class="las la-plus"></span><span>Admin</span></a>
                </li>-->
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
                <span class="las la-sun {{ $theme == 'light' ? 'active' : ''}}"></span>
                <span class="las la-moon {{ $theme == 'dark' ? 'active' : ''}}"></span>
            </div>

            <div class="user-wrapper">
                

                <div class="d-flex">
                    <p class="my-auto mr-5"> {{ Auth::user()->name }}</p>
                    @if (Auth()->user()->student->img_path)

                    <img src="{{ Storage::url(Auth()->user()->student->img_path) }}" 
                    alt="" class="img-fluid" height="44px" width="44px">

                    @endif
                    
                </div>
                
            </div>

        </section>

        <main class="card-container">
            
            @yield('content')    

        </main>
    </div>

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> --}}


    {{-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
          document.getElementById("form").submit();
      };
    </script> --}}

    <script>
        const themeToggler = document.querySelector(".dark-mode");
        themeToggler.addEventListener('click', () => {
            // document.body.classList.toggle('dark-theme-variables');
            if (document.body.classList.contains('dark-theme-variables')) {
                document.body.classList.remove('dark-theme-variables')
                setCookie('theme', 'light');
            } else {
                document.body.classList.add('dark-theme-variables')
                setCookie('theme', 'dark');
            }

            themeToggler.querySelector('span:nth-child(1)').classList.toggle('active');
            themeToggler.querySelector('span:nth-child(2)').classList.toggle('active');
        })
        function setCookie(name, value) {
            var d = new Date();
            d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = name + "=" + value + ";" + expires + ";path=/";
        }
    </script>

    <script>
        $(document).ready(function() {
        $('#example').DataTable();
    } );
    </script>

</body>

</html>