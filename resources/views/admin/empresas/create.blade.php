@extends('adminlte::master')

@php
    $authType = $authType ?? 'login';
    $dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
    } else {
        $dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
    }

    $bodyClasses = "{$authType}-page";

    if (! empty(config('adminlte.layout_dark_mode', null))) {
        $bodyClasses .= ' dark-mode';
    }
@endphp

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body'){{ $bodyClasses }}@stop

@section('body')
    <div class="container">
        <br>
        <center>
            <img src="" alt="">
        </center>
        <br>
        <div class="row">
            <div class="col-md-12">
                {{-- Card Box --}}
                <div class="card {{ config('adminlte.classes_auth_card', 'card-outline card-primary') }}">

                    {{-- Card Header --}}
                    <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                        <h3 class="card-title float-none text-center">
                            <b>Registro de una nueva empresa</b>
                        </h3>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body {{ $authType ?? 'login'}}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                        <form action="{{url('crear-empresa/create')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="file">Logotipo</label>
                                        <input type="file" id="file" name="logo" class="form-control" accept="image/jpeg, image/png, image/gif">
                                        @error('logo')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        <br>
                                        <center><output id="list"></output></center>
                                        <script>
                                            function archivo(evt) {
                                                var files = evt.target.files;
                                                var output = document.getElementById("list");
                                                output.innerHTML = ''; // Limpiar la previsualización anterior

                                                for (var i = 0, f; f = files[i]; i++) {
                                                    if (!f.type.match('image.*')) {
                                                        continue; // Ignorar archivos que no sean imágenes
                                                    }

                                                    var reader = new FileReader();
                                                    reader.onload = (function(theFile) {
                                                        return function(e) {
                                                            // Mostrar la previsualización de la imagen
                                                            output.innerHTML = ['<img class="thumb thumbnail" src="', e.target.result, '" width="200" height="200" title="', escape(theFile.name), '"/>'].join('');
                                                        };
                                                    })(f);
                                                    reader.readAsDataURL(f);
                                                }
                                            }
                                            document.getElementById('file').addEventListener('change', archivo, false);
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">País</label>
                                            <select name="pais" id="select_pais" class="form-control">
                                                @foreach ($paises as $paise )
                                                    <option value="{{$paise->id}}">{{$paise->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Departamento</label>
                                            <div id="respuesta_pais"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Ciudad</label>
                                            <div id="respuesta_estado"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Nombre Empresa</label><b>*</b>
                                            <input type="text" name="nombre_empresa" value="{{old('nombre_empresa')}}" class="form-control" required>
                                            @error('nombre_empresa')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Tipo de Empresa</label><b>*</b>
                                            <input type="text" name="tipo_empresa" value="{{old('tipo_empresa')}}" class="form-control" required>
                                            @error('tipo_empresa')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">NIT</label><b>*</b>
                                            <input type="text" name="nit" value="{{old('nit')}}" class="form-control" required>
                                            @error('nit')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="">Moneda</label>
                                            <select name="moneda" id="" class="form-control">
                                                @foreach ($monedas as $moneda )
                                                    <option value="{{$moneda->id}}">{{$moneda->symbol}}</option>
                                                @endforeach
                                            </select>    
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="">Nombre del impuesto</label><b>*</b>
                                            <input type="text" name="nombre_impuesto" value="{{old('nombre_impuesto')}}" class="form-control" required>
                                            @error('nombre_impuesto')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <label for="">Cantidad</label><b>*</b>
                                            <input type="number" name="cantidad_impuesto" value="{{old('cantidad_impuesto')}}" class="form-control" required>
                                            @error('cantidad_impuesto')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Teléfonos de la Empresa</label><b>*</b>
                                            <input type="text" name="telefono" value="{{old('telefono')}}" class="form-control" required>
                                            @error('telefono')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Correo de la Empresa</label><b>*</b>
                                            <input type="email" name="correo" value="{{old('correo')}}" class="form-control" required>
                                            @error('correo')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <label for="">Dirección</label><b>*</b>
                                            <input type="address" name="direccion" value="{{old('direccion')}}" class="form-control" required>
                                            @error('direccion')
                                            <small class="text-danger" style="color::red">{{$message}}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Código Postal</label>
                                                <select name="codigo_postal" id="" class="form-control">
                                                    @foreach ($paises as $paise)
                                                        <option value="{{$paise->phone_code}}">{{$paise->phone_code}}</option>
                                                    @endforeach
                                                </select>  
                                            </div>
                                        </div> 
                                    </div>

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Crear Empresa</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Card Footer --}}
                    @hasSection('auth_footer')
                        <div class="card-footer {{ config('adminlte.classes_auth_footer', '') }}">
                            @yield('auth_footer')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')

    <script>
        $('#select_pais').on('change', function () {
            var id_pais = $('#select_pais').val();
            //alert(pais);
            if(id_pais){
                $.ajax({
                    url:"{{url('/crear-empresa/pais/')}}"+'/'+id_pais,
                    type: 'GET',
                    success: function (data) {
                        $('#respuesta_pais').html(data);
                    }
                });
            }
            else{
                alert("Debe seleccionar un pais")
            }
        });
    </script>

    <script>
        $(document).on('change', '#select_estado', function () {
            var id_estado = $(this).val();
            //alert(id_estado)

            if(id_estado){
                $.ajax({
                    url:"{{url('/crear-empresa/estado/')}}"+'/'+id_estado,
                    type: 'GET',
                    success: function (data) {
                        $('#respuesta_estado').html(data);
                    }
                });
            }
            else{
                alert("Debe seleccionar un pais")
            }
        });
    </script>
@stop
