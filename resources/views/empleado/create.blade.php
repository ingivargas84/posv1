@extends('layouts.app')
@section('content')
{!! Form::open( array( 'action' => array('EmpleadoController@store')  , 'id' => 'submit-empleado') ) !!}
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("emp_cui","CUI - DPI:") !!}
        {!! Form::text( "emp_cui" , null , ['class' => 'form-control' , 'placeholder' => 'CUI-DPI del Empleado' ]) !!}
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
        {!! Form::label("emp_direccion","Dirección:") !!}
        {!! Form::text( "emp_direccion" , null , ['class' => 'form-control' , 'placeholder' => 'Dirección' ]) !!}
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-3">
        {!! Form::label("emp_nombres","Nombres del Empleado:") !!}
        {!! Form::text( "emp_nombres" , null , ['class' => 'form-control' , 'placeholder' => 'Nombres del Empleado' ]) !!}
    </div>
    <div class="col-sm-3">
        {!! Form::label("emp_apellidos","Apellidos del Empleado:") !!}
        {!! Form::text( "emp_apellidos" , null , ['class' => 'form-control' , 'placeholder' => 'Apellidos del Empleado' ]) !!}
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("emp_telefonos","Telefonos:") !!}
        {!! Form::text( "emp_telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefonos' ]) !!}
    </div>
    <!-- {!! Form::label("cargo_id","Cargo:") !!}
    <br>
    <select class="selectpicker data" id='cargo_id' name="cargo_id" value="{{ old('cargo')}}" data-live-search="true">
        @foreach ($cargos as $cargo)
        <option value="{{$cargo->id}}">{{ $cargo->cargo}}</option>;
        @endforeach
    </select> -->
</div>
<div class="text-right m-t-15">
<a class='btn btn-success' href="{{ url('/cliente') }}">Regresar</a>
{!! Form::submit('Agregar Nuevo Empleado' , ['class' => 'btn btn-success btn-submit-empleado' , 'data-loading-text' => 'Processing...' ]) !!}
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/empleado/create.js') !!}
@endsection