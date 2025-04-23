@extends('adminlte::page')

@section('title', 'Dashboard')
    
@section('content_header')
<h1>Configuracion/Editar</h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- Card Box --}}
        <div class="card card-outline card-success">

            {{-- Card Header --}}
            <div class="card-header {{ config('adminlte.classes_auth_header', '') }}">
                <h3 class="card-title float-none">
                    <b>Datos Registrados</b>
                </h3>
            </div>

            {{-- Card Body --}}
            <div class="card-body {{ $authType ?? 'login'}}-card-body {{ config('adminlte.classes_auth_body', '') }}">
                <form action="{{url('/admin/configuracion',$empresa->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="logo">Logotipo</label>
                                <input type="file" id="file" name="logo" class="form-control" accept="image/jpeg, image/png, image/gif">
                                <br>
                                
                                <!-- Mostrar la imagen actual si ya existe -->
                                <center>
                                    <output id="list">
                                        @if($empresa->logo)
                                            <img src="{{ asset('storage/'.$empresa->logo) }}" alt="logo" width="200px" height="200px">
                                        @else
                                            <p>No hay logo cargado.</p>
                                        @endif
                                    </output>
                                </center>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="">País</label>
                                    <select name="pais" id="select_pais" class="form-control">
                                        @foreach ($paises as $paise )
                                            <option value="{{$paise->id}}" {{$empresa->pais == $paise->id ? 'selected': ''}}>{{$paise->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="">Departamento</label>
                                    <select name="departamento" id="select_estado_2" class="form-control">
                                        @foreach ($estados as $estado )
                                        <option value="{{$estado->id}}" {{$empresa->departamento == $estado->id ? 'selected': ''}}>{{$estado->name}}</option>
                                
                                        @endforeach
                                    </select>    
                                    <div id="respuesta_pais"></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Ciudad</label>
                                        <select name="ciudad" id="select_ciudades_2" class="form-control">
                                            @foreach ($ciudades as $ciudade )
                                            <option value="{{$ciudade->id}}" {{$empresa->ciudad == $ciudade->id ? 'selected': ''}}>{{$ciudade->name}}</option>

                                            @endforeach
                                        </select>   
                                    <div id="respuesta_estado"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Nombre Empresa</label><b>*</b>
                                    <input type="text" name="nombre_empresa" value="{{$empresa->nombre_empresa}}" class="form-control" required>
                                    @error('nombre_empresa')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="">Tipo de Empresa</label><b>*</b>
                                    <input type="text" name="tipo_empresa" value="{{$empresa->tipo_empresa}}" class="form-control" required>
                                    @error('tipo_empresa')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">NIT</label><b>*</b>
                                    <input type="text" name="nit" value="{{$empresa->nit}}" class="form-control" required>
                                    @error('nit')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="">Moneda</label>
                                    <select name="moneda" id="" class="form-control">
                                        @foreach ($monedas as $moneda )
                                            <option value="{{$moneda->id}}" {{$empresa->moneda == $moneda->id ? 'selected': ''}}>{{$moneda->symbol}}</option>
                                        @endforeach
                                    </select>    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">Nombre del impuesto</label><b>*</b>
                                    <input type="text" name="nombre_impuesto" value="{{$empresa->nombre_impuesto}}" class="form-control" required>
                                    @error('nombre_impuesto')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="">Cantidad</label><b>*</b>
                                    <input type="number" name="cantidad_impuesto" value="{{$empresa->cantidad_impuesto}}" class="form-control" required>
                                    @error('cantidad_impuesto')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="">Teléfonos de la Empresa</label><b>*</b>
                                    <input type="text" name="telefono" value="{{$empresa->telefono}}" class="form-control" required>
                                    @error('telefono')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="">Correo de la Empresa</label><b>*</b>
                                    <input type="email" name="correo" value="{{$empresa->correo}}" class="form-control" required>
                                    @error('correo')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <label for="">Dirección</label><b>*</b>
                                    <input type="address" name="direccion" value="{{$empresa->direccion}}" class="form-control" required>
                                    @error('direccion')
                                    <small class="text-danger" style="color::red">{{$message}}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Código Postal</label>
                                        <select name="codigo_postal" id="" class="form-control">
                                            @foreach ($paises as $paise)
                                                <option value="{{$paise->phone_code}}" {{$empresa->codigo_postal == $paise->id ? 'selected': ''}}>{{$paise->phone_code}}</option>
                                            @endforeach
                                        </select>  
                                    </div>
                                </div> 
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success btn-block">Actualizar Datos</button>
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
@stop

@section('css')
    
@stop

@section('js')

<script>
    $('#select_pais').on('change', function () {
        var id_pais = $('#select_pais').val();
        //alert(pais);
        if(id_pais){
            $.ajax({
                url:"{{url('/crear-empresa/pais/')}}"+'/'+id_pais,
                type: 'GET',
                success: function (data) {
                    $('#select_estado_2').css('display', 'none')
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
                    $('#select_ciudades_2').css('display', 'none')
                    $('#respuesta_estado').html(data);
                }
            });
        }
        else{
            alert("Debe seleccionar un pais")
        }
    });
</script>
<script>
    function archivo(evt){
        var files = evt.target.files;
        for(var i=0, f; f=files[i]; i++){
            if(!f.type.match('image.*')){
                continue;
            }
        var reader = new  FileReader();
        reader.onload = (function (theFile) {
                return function (e){
                    document.getElementById("list").innerHTML = ['<img class="thumb thumbnail" src="',e.target.result, '" width="300" height="200" title="',escape (theFile.name), '"/>'].join('');

                };

                })(f);
                reader.readAsDataURL(f);
            }
        }
        document.getElementById('file').addEventListener('change', archivo, false);

    

</script>
@stop