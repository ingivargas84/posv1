@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <tr>
                {!! Form::open( array( 'action' => array('PdfController@pdf_salidas')  , 'id' => 'submit-salidaproducto') ) !!}
                <div clas="row">
                    <div class="col-sm-3">
                        {!! Form::label("fecha_inicio","Fecha de Inicio:") !!}
                        {!! Form::text( "fecha_inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Inicio' ]) !!}
                    </div>
                    <div class="col-sm-3">
                        {!! Form::label("fecha_final","Fecha Final:") !!}
                        {!! Form::text( "fecha_final" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Final' ]) !!}
                    </div>
                    <div class="col-sm-3">
                        <br>
   {!! Form::submit('Generar PDF' , ['class' => 'btn btn-success btn-submit-salidaproducto' , 'data-loading-text' => 'Processing...' ]) !!}
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
                <h4 class="inline-title">Salidas de Productos por Fechas</h4>
            </div>
            <div class="col-sm-3 title-line-height text-right">
                <div class="btn-group">
                    <a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-body">
        <table id="salida-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
        </table>
    </div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/salida/salida.js') !!}
<!-- <script src="{{ URL::to( "/js/cargo/cargo.js" ) }}"></script> -->
@endsection