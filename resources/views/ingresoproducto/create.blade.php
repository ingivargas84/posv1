@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-3">
        {!! Form::label("proveedor_id","Proveedor:") !!}
        <br>
        <select class="selectpicker data" id='proveedor_id' name="proveedor_id" value="{{ old('company')}}" data-live-search="true">
            @foreach ($proveedores as $proveedor)
            <option value="{{$proveedor->id}}">{{ $proveedor->nombre_comercial}}</option>;
            @endforeach
        </select>
    </div>
    <div class="col-sm-3">
    {!! Form::label("fecha_ingreso","Fecha de Compra:") !!}
    {!! Form::text( "fecha_ingreso" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Compra' ]) !!}
</div>
<div class="col-sm-3">
    {!! Form::label("fecha_factura","Fecha de Factura:") !!}
    {!! Form::text( "fecha_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Factura' ]) !!}
</div>
    <div class="col-sm-3">
        {!! Form::label("edo_ingreso_id","Estado:") !!}
        {!! Form::text( "edo_ingreso_id" , "Activo", ['class' => 'form-control' , 'disabled' ]) !!}
    </div>

</div>
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("producto","Producto:") !!}
        <br>
        <select class="form-control selectpicker" id='producto_id' name="producto_id" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione un producto">
        </select>
       <!--  {!! Form::text( "codigobarra" , null, ['class' => 'form-control' ]) !!}
       {!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!} -->
       {!! Form::hidden("subtotal" , null , ['class' => 'form-control' , 'disabled']) !!}
       <span id="api-type-error" class="help-block hidden">
        <strong></strong>
    </span>
</div>
<div class="col-sm-3">
        {!! Form::label("serie_factura","Serie de Factura:") !!}
        {!! Form::text( "serie_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Serie de Factura' ]) !!}
    </div>
<div class="col-sm-3">
    {!! Form::label("num_factura","Número de Factura:") !!}
    {!! Form::text( "num_factura" , null , ['class' => 'form-control' , 'placeholder' => 'Número de Factura' ]) !!}
</div>

</div>
<br>
<div class="row">

    <div class="col-sm-3">
        {!! Form::label("Descripción","Descripción:") !!}
        {!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'disabled',  'placeholder' => 'Descripción del Producto' ]) !!}
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-3">
        {!! Form::label("cantidad_ingreso","Cantidad:") !!}
        {!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad' ]) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label("precio_compra","Precio de Compra:") !!}
        {!! Form::text( "precio_compra" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Compbra' ]) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label("precio_venta","Precio de Venta:") !!}
        {!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Venta']) !!}
    </div>
</div>
<br>
<div class="row">
</div>
<div class="text-right m-t-15">
    {!! Form::button('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,
    'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
<br>
<div id="compradetalle-grid"></div>
<br>
<div class="col-sm-4" id="total">
    {!! Form::label("Total","Total:") !!}
    {!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
</div>
<div class="text-right m-t-15">
    {!! Form::submit('Agregar Nueva Compra' , ['class' => 'btn btn-success btn-submit-ingresoproducto', 'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/ingresoproducto/create.js') !!}
{!! HTML::script('/js/ingresoproducto/grid.js') !!}
@endsection