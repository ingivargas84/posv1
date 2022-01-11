@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-sm-6">
		{!! Form::label("tipo_venta","Tipo Venta:") !!}
		<select class="form-control" id='tipo_venta_id' name="tipo_venta_id" value="{{ old('role')}}">
			@foreach ($tipo_ventas as $tipo_venta)
			<option value="{{$tipo_venta->id}}">{{ $tipo_venta->tipo_venta}}</option>;
			@endforeach
		</select>
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
	{!! Form::label("Producto","Producto:") !!}
	<!-- {!! Form::text( "codigobarra" , null , ['class' => 'form-control' , 'placeholder' => 'Código de Barras' ]) !!} -->
	<select class="form-control selectpicker" id='producto_id' name="producto_id" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione un producto">
	</select>
</div>
<div class="col-sm-3">
	{!! Form::label("cantidad","Cantidad:") !!}
	{!! Form::text( "cantidad" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad']) !!}
</div>
<div class="col-sm-3">
	{!! Form::label("subtotal","Sub-Total:") !!}
	{!! Form::text( "subtotal" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => 'Sub-Total' ]) !!}
</div>
</div>
<div class="row">
	<div class="col-sm-6">
		{!! Form::label("Descripción","Descripción:") !!}
		{!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'disabled',  'placeholder' => 'Descripción del Producto' ]) !!}
		<span id="api-type-error" class="help-block hidden">
			<strong></strong>
		</span>
	</div>
	<div class="col-sm-3">
		{!! Form::label("venta","Precio de Venta:") !!}
		{!! Form::text( "precio_venta" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => 'Precio de Venta' ]) !!}
		{!! Form::hidden("precio_compra" , null , ['class' => 'form-control' , 'disabled']) !!}
		{!! Form::hidden("movimiento_id" , null , ['class' => 'form-control' , 'disabled']) !!}
		{!! Form::hidden("existencias" , null , ['class' => 'form-control' , 'disabled']) !!}
		{!! Form::hidden("venta_maestro" , null , ['class' => 'form-control' , 'disabled']) !!}
	</div>
	<div class="col-sm-3">
		{!! Form::label("fecha","Fecha:") !!}
		{!! Form::text( "created_at" , $today, ['class' => 'form-control', 'disabled', 'placeholder' => 'Precio de Compra' ]) !!}
	</div>
</div>
<div id='total_existencia' style="font-size:16px; font-weight:bold; color:green"> </div>
<br>
<div class="text-right m-t-15">
	{!! Form::submit('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,
	'id' => 'addDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
<br>
<div id="detalle-grid"></div>
<div class="row" >
	<br>
	<div class="col-sm-4" id="total">
		{!! Form::label("Total","Total:") !!}
		{!! Form::text( "total" , null, ['class' => 'form-control', 'id' => 'total', 'disabled']) !!}
	</div>
	<div class="col-sm-4" id="total">
		{!! Form::label("Efectivo","Efectivo:") !!}
		{!! Form::text( "efectivo" , null, ['class' => 'form-control', 'id' => 'efectivo']) !!}
	</div>
	<div class="col-sm-4" id="total">
		{!! Form::label("Cambio","Cambio:") !!}
		{!! Form::text( "cambio", null, ['class' => 'form-control', 'id' => 'cambio', 'disabled']) !!}
	</div>
</div>
<div class="text-right m-t-15">
	{!! Form::submit('Guardar Venta' , ['class' => 'btn btn-success' ,
	'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/venta/create.js') !!}
{!! HTML::script('/js/venta/edit.js') !!}
@endsection