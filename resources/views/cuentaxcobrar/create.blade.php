@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-sm-6">
		{!! Form::label("empleado_id","Empleado:") !!}
		<select class="form-control" id='empleado_id' name="empleado_id" value="{{ old('role')}}">
			@foreach ($empleados as $empleado)
			<option value="{{$empleado->id}}">{{ $empleado->emp_nombres}}</option>;
			@endforeach
		</select>
		<span id="api-type-error" class="help-block hidden">
			<strong></strong>
		</span>
	</div>
	<div class="col-sm-3">
		{!! Form::label("tienda","Tienda:") !!}
		{!! Form::text( "tienda" , "Market Telecután", ['class' => 'form-control' , 'disabled' ]) !!}
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
		{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!}
	</div>
	<div class="col-sm-3">
		{!! Form::label("fecha","Fecha:") !!}
		{!! Form::text( "created_at" , $today, ['class' => 'form-control', 'disabled', 'placeholder' => 'Precio de Compra' ]) !!}
	</div>
</div>
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
	<!-- <div class="col-sm-4" id="total">
		{!! Form::label("Efectivo","Efectivo:") !!}
		{!! Form::text( "efectivo" , null, ['class' => 'form-control', 'id' => 'efectivo']) !!}
	</div>
	<div class="col-sm-4" id="total">
		{!! Form::label("Cambio","Cambio:") !!}
		{!! Form::text( "cambio", null, ['class' => 'form-control', 'id' => 'cambio', 'disabled']) !!}
	</div> -->
</div>
<div class="text-right m-t-15">
	{!! Form::submit('Guardar Venta' , ['class' => 'btn btn-success' ,
	'id' => 'ButtonDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/cuentaxcobrar/create.js') !!}
{!! HTML::script('/js/cuentaxcobrar/edit.js') !!}
@endsection