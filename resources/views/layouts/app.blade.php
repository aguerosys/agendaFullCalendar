<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- css full calendar --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.css">

    {{-- full calendar js --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/locales-all.js"></script>

    <script type="text/javascript">
        var baseURL = {!! json_encode(url('/')) !!}
    </script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Agenda personal
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <script>

            document.addEventListener('DOMContentLoaded', function() {
            
              let formulario = document.querySelector("#formularioEventos"); //seleccionamos el form para recuperar los datos
              var calendarEl = document.getElementById('calendar');
              var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
        
                locale: "es",
                displayEventTime:false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth'
                },
                
                //events: 'http://127.0.0.1:8000/evento/mostrar'  ,

                eventSources:{
                    url: baseURL+"/evento/mostrar",
                    method: "POST",
                    extraParams:{
                        _token: formulario._token.value,
                    }
                },

                dateClick: function(info){

                    formulario.reset();
                    formulario.start.value=info.dateStr;
                    formulario.end.value=info.dateStr;

                    $("#event").modal("show");
                },
                eventClick:function(info){
                    var event = info.event;
                    console.log(event);
                    axios.post(baseURL+'/evento/editar/'+info.event.id).
                        then(
                            (respuesta) =>{
                                    formulario.id.value=respuesta.data.id;
                                    formulario.title.value= respuesta.data.title;
                                    formulario.description.value= respuesta.data.description;
                                    formulario.start.value= respuesta.data.start;
                                    formulario.end.value= respuesta.data.end;
                                    $('#event').modal('show');
                            }
                        ).catch(
                            error=>{
                                if(error.response){
                                    console.log(error.response.data)
                                }
                            }
                        )
                },


              });
              calendar.render(); //renderiza el calendario

              //caputramos los datos

              document.getElementById('btnGuardar').addEventListener("click", function()
              {
                    enviarDatos('/evento/agregar');
              });

              document.getElementById('btnEliminar').addEventListener("click", function()
              {
                    enviarDatos('/evento/borrar/'+formulario.id.value);
              });

              document.getElementById('btnModificar').addEventListener("click", function()
              {
                    enviarDatos('/evento/actualizar/'+formulario.id.value);
              });

                function enviarDatos(url){

                    const datos = new FormData(formulario);
                    const nuevaURL = baseURL+url;

                    axios.post(nuevaURL, datos).
                    then(
                        (respuesta) =>{
                                calendar.refetchEvents();
                                $('#event').modal('hide');
                        }
                    ).catch(
                        error=>{
                            if(error.response){
                                console.log(error.response.data)
                            }
                        }
                    )
                }

            });
      
          </script>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
