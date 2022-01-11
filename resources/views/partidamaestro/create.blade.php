@extends('layouts.app')
@section('content')
<div class="row">
	<div class="col-sm-6">
		{!! Form::label("tipo_ajuste","Tipo Ajuste:") !!}
		<select class="form-control" id='tipo_ajuste_id' name="tipo_ajuste_id" value="{{ old('role')}}">
			@foreach ($tipo_ajuste as $tipo_ajuste)
			<option value="{{$tipo_ajuste->id}}">{{ $tipo_ajuste->tipo_ajuste}}</option>;
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
		{!! Form::label("codigo","Producto:") !!}
		        <select class="form-control selectpicker" id='producto_id' name="producto_id" data-live-search="true" data-live-search-placeholder="Búsqueda" title="Seleccione un producto">
        </select>
		<!-- {!! Form::text( "codigobarra" , null , ['class' => 'form-control' , 'placeholder' => 'Código de Barras' ]) !!} -->
	</div>
	<div class="col-sm-3">
		{!! Form::label("cantidad","Cantidad:") !!}
		{!! Form::text( "cantidad_ajuste" , null , ['class' => 'form-control' , 'placeholder' => 'Cantidad']) !!}
	</div>
	<div class="col-sm-3">
		{!! Form::label("compra","Precio de Compra:") !!}
		{!! Form::text( "precio_costo" , null , ['class' => 'form-control' , 'placeholder' => 'Precio de Compra']) !!}
	</div>
</div>
<br>
<div class="row">
	<div class="col-sm-6">
		{!! Form::label("Descripción","Descripción:") !!}
		{!! Form::text( "descripcion" , null , ['class' => 'form-control' , 'disabled',  'placeholder' => 'Descripción del Producto' ]) !!}
		<span id="api-type-error" class="help-block hidden">
			<strong></strong>
		</span>
	</div>
	<div class="col-sm-3">
		{!! Form::label("subtotal","Sub-Total:") !!}
		{!! Form::text( "subtotal" , null , ['class' => 'form-control' , 'disabled', 'placeholder' => 'Sub-Total' ]) !!}
	</div>
	<div class="col-sm-3">
		{!! Form::hidden("existencias" , null , ['class' => 'form-control' , 'disabled']) !!}
<!-- 		{!! Form::hidden("producto_id" , null , ['class' => 'form-control' , 'disabled']) !!} -->
		{!! Form::hidden("partida_maestro" , null , ['class' => 'form-control' , 'disabled']) !!}
		{!! Form::hidden("movimiento_id" , null , ['class' => 'form-control' , 'disabled']) !!}
	</div>
</div>
<div id='total_existencia' style="font-size:16px; font-weight:bold; color:green"> </div>
<br>
<div class="text-right m-t-15">
	{!! Form::submit('Agregar Nuevo Producto' , ['class' => 'btn btn-success' ,
	'id' => 'addPartidaDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
<br>
<div id="partidadetalle-grid"></div>
<div class="row" >
	<br>
	<div class="col-sm-4" id="total de Ingreso">
		{!! Form::label("TotalI","Total de Ingreso:") !!}
		{!! Form::text( "total_ingreso" , null, ['class' => 'form-control', 'id' => 'Total de Ingreso', 'disabled']) !!}
	</div>
	<div class="col-sm-4" id="total de Salida">
		{!! Form::label("TotalS","Total de Salida:") !!}
		{!! Form::text( "total_salida" , null, ['class' => 'form-control', 'id' => 'Total de Salida', 'disabled' ]) !!}
	</div>
	<div class="col-sm-4" id="diferencia">
		{!! Form::label("dif","Diferencia:") !!}
		{!! Form::text( "diferencia", null, ['class' => 'form-control', 'id' => 'Diferencia']) !!}
	</div>
</div>
<div class="text-right m-t-15">
	{!! Form::submit('Guardar Partida de Ajuste' , ['class' => 'btn btn-success' ,
	'id' => 'ButtonPartidaDetalle', 'data-loading-text' => 'Processing...' ]) !!}
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/partidamaestro/create.js') !!}
{!! HTML::script('/js/partidamaestro/edit.js') !!}
@endsection