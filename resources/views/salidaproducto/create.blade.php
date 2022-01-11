@extends('layouts.app')
@section('content')
{!! Form::open( array( 'action' => array('SalidaProductoController@store')  , 'id' => 'submit-salidaproducto') ) !!}
<div class="row">
    <div class="col-sm-4">
        {!! Form::label("producto_id","Producto:") !!}
        <br>
        <select class="selectpicker data" id='producto_id' name="producto_id" value="{{ old('company')}}" data-live-search="true">
            @foreach ($productos as $producto)
            <option value="{{$producto->id}}">{{ $producto->prod_nombre}}</option>;
            @endforeach
        </select>
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-4">
        {!! Form::label("cantidad_salida","Cantidad:") !!}
        {!! Form::text( "cantidad_salida" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-4">
        {!! Form::label("tipo_salida_id","Tipo de Salida:") !!}
        <br>
        <select class="selectpicker data" id='tipo_salida_id' name="tipo_salida_id" value="{{ old('company')}}" data-live-search="true">
            @foreach ($tipo_salidas as $tipo_salida)
            <option value="{{$tipo_salida->id}}">{{ $tipo_salida->tipo_salida}}</option>;
            @endforeach
        </select>
    </div>
    <div class="col-sm-4">
        {!! Form::label("fecha_salida","Fecha de Salida:") !!}
        {!! Form::text( "fecha_salida" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Salida' ]) !!}
    </div>
    <br>
    <div class="col-sm-4 text-right m-t-15" style="margin-top: 6px;">
        {!! Form::submit('Agregar Nueva Salida de Producto' , ['class' => 'btn btn-success btn-submit-producto' , 'data-loading-text' => 'Processing...' ]) !!}
    </div>
</div>
<br>

{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/salidaproducto/create.js') !!}
@endsection