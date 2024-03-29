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
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet"/>
    {{-- PLUGINS BUTTONS--}}
    <link href="https://cdn.datatables.net/v/bs5/b-2.3.6/b-print-2.3.6/datatables.min.css" rel="stylesheet"/>



    


</head>


<body class="{{ $theme == 'dark' ? 'dark-theme-variables' : ''}}" >






    <input type="checkbox" name="" id="nav-toggle">
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2>
                <img src="{{ Storage::url('default/LIBRARYLOGOv2.png') }}" alt="" class="img-fluid"
                    height="128px" width="128px">
                <span class="fs-5 my-auto">LIBRARY QUERY </span>
            </h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->is('admin_dashboard') ? 'active' : '' }}"><span
                            class="las la-home"></span><span>Home</span></a>
                </li>

                <li>
                    <a href="{{ route('admin.student.index') }}"
                        class="{{ request()->is('admin/student*') ? 'active' : '' }}"><span
                            class="las la-user-friends"></span><span>Students</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.books.index') }}"
                        class="{{ request()->is('admin/books*') ? 'active' : '' }}"><span
                            class="las la-book"></span><span>Books</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.profile.edit', ['admin'=>Auth()->user()->id]) }}"
                        class="{{ request()->is('admin/profile*') ? 'active' : '' }}"><span
                            class="las la-user-circle"></span><span>Profile</span></a>
                </li>

                <li>
                    <a href="{{ route('admin.add.index') }}"
                        class="{{ request()->is('admin/list*') ? 'active' : '' }}"><span
                            class="las la-user-plus"></span><span>Admin List</span></a>
                </li>
                {{-- <li>
                    <a href="#" onclick="event.preventDefault();"><span class="las la-plus"></span><span>Admin</span></a>
                </li> --}}
                <li id="logout">
                    <a href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span
                            class="las la-sign-out-alt"></span><span>Logout</span></a>
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
                <span class="las la-sun  {{ $theme == 'light' ? 'active' : ''}}"></span>
                <span class="las la-moon {{ $theme == 'dark' ? 'active' : ''}}"></span>
            </div>

            <div class="user-wrapper">

                <div class="d-flex">
                    <p class="my-auto mr-5"> {{ Auth::user()->name }}</p>


                    <img src="{{ Storage::url('default/LIBRARYLOGOv2.png') }}" alt="" class="img-fluid"
                        height="44px" width="44px">


                </div>


            </div>

        </section>

        <main class="card-container fs-2">

            @yield('content')


        </main>
    </div>

    {{-- SWEET ALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>
    {{-- PLUGINS BUTTONS--}}
    <script src="https://cdn.datatables.net/v/bs5/b-2.3.6/b-print-2.3.6/datatables.min.js"></script>
    

    
 
    
    


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

            // console.log(document.body.hasClass('dark-theme-variables'));
            // console.log($('body').hasClass('dark-theme-variables'));

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
        // if(document.getElementById('nav-toggle').checked){
        //     alert('open');
        // }else{
        //     alert('close');
        // }

        
        // if($('.sidebar').css('width') == '250px'){
        //     alert('pota');
        // }

        
    </script>



</body>

</html>
