@extends('layouts.app')
@section('content')
{!! Form::open( array( 'action' => array('ProductoController@store')  , 'id' => 'submit-producto') ) !!}
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("producto","Producto:") !!}
        {!! Form::text( "prod_nombre" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre del Producto' ]) !!}
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-3">
        {!! Form::label("tienda","Tienda:") !!}
        {!! Form::text( "tienda" , "Licores y más", ['class' => 'form-control' , 'disabled' ]) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label("estado","Estado:") !!}
        {!! Form::text( "estado" , "Activo", ['class' => 'form-control' , 'disabled' ]) !!}
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("codigo","Código de Barras:") !!}
        {!! Form::text( "codigobarra" , null , ['class' => 'form-control' , 'placeholder' => 'Código de Barras' ]) !!}
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-3">
        {!! Form::label("minimo","Minimo:") !!}
        {!! Form::text( "minimo" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad Mínima' ]) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label("precio_venta","Precio de Venta:") !!}
        {!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta' ]) !!}
    </div>

</div>

<div class="text-right m-t-15">
    <a class='btn btn-success' href="{{ url('/producto') }}">Regresar</a>

    {!! Form::submit('Agregar Nuevo Producto' , ['class' => 'btn btn-success btn-submit-producto' , 'data-loading-text' => 'Processing...' ]) !!}
</div>

{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/producto/create.js') !!}
@endsection