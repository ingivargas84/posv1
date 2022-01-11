@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<tr>
				{!! Form::open( array( 'action' => array('PdfController@pdf_ventasuf')  , 'id' => 'submit-ventasuf') ) !!}
				<div clas="row">
					<div class="col-sm-3">
						{!! Form::label("fecha_inicio","Fecha:") !!}
						{!! Form::text( "fecha_inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha' ]) !!}
					</div>
					<div class="col-sm-3">
						{!! Form::label("user","Usuario:") !!}
						<!-- {!! Form::text( "user" , null , ['class' => 'form-control' , 'placeholder' => 'Usuario' ]) !!} -->

						<select class="form-control" id='userslst' name="userslst" value="{{ old('role')}}">
							@foreach ($lst_user as $data)
							<option value="{{$data->id}}">{{ $data->name}}</option>;
							@endforeach
						</select>

					</div>
					<div class="col-sm-3">
						<br>
						{!! Form::submit('Generar Excel' , ['class' => 'btn btn-success btn-submit-ventasuf' , 'data-loading-text' => 'Processing...' ]) !!}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	<br>
	<div class="panel panel-default">
		<div class="panel panel-heading">
			<div class="row">
				<div class="col-sm-3 title-line-height"></div>
				<div class="col-sm-6 text-center">
					<h4 class="inline-title">Ventas por Fechas y Usuario</h4>
				</div>
				<div class="col-sm-3 title-line-height text-right">
					<div class="btn-group">
						<a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Delete</a>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-body">
			<table id="ventasuf-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
			</table>
		</div>
	</div>
	@endsection
	@section('scripts')
	{!! HTML::script('/js/venta/ventasuf.js') !!}
	@endsection