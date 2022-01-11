@extends('layouts.app')
@section('content')
{!! Form::open( array( 'action' => array('ProveedorController@store')  , 'id' => 'submit-proveedor') ) !!}
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("nit","NIT:") !!}
        {!! Form::text( "nit" , null , ['class' => 'form-control' , 'placeholder' => 'NIT' ]) !!}
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-6">
        {!! Form::label("telefonos","Telefono:") !!}
        {!! Form::text( "telefonos" , null , ['class' => 'form-control' , 'placeholder' => 'Telefonos' ]) !!}
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm-6">
        {!! Form::label("nombre_comercial","Nombre Comercial:") !!}
        {!! Form::text( "nombre_comercial" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Comercial' ]) !!}
        <span id="api-type-error" class="help-block hidden">
            <strong></strong>
        </span>
    </div>
    <div class="col-sm-6">
        {!! Form::label("nombre_contable","Nombre Contable:") !!}
        {!! Form::text( "nombre_contable" , null , ['class' => 'form-control' , 'placeholder' => 'Nombre Contable' ]) !!}
    </div>
</div>
<div class="row">

</div>
<div class="row">
</div>
<div class="text-right m-t-15">
    <a class='btn btn-success' href="{{ url('/proveedor') }}">Regresar</a>

    {!! Form::submit('Agregar Nuevo Proveedor' , ['class' => 'btn btn-success btn-submit-proveedor' , 'data-loading-text' => 'Processing...' ]) !!}
</div>
{!! Form::close() !!}
@endsection
@section('scripts')
{!! HTML::script('/js/proveedor/create.js') !!}
@endsection