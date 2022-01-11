@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
    <div class="col-md-12">
        <tr>
            {!! Form::open( array( 'action' => array('PdfController@pdf_ajustes')  , 'id' => 'submit-ajustes') ) !!}
            <div clas="row">
                <div class="col-sm-3">
                {!! Form::label("codigo_partida","Código de Partida:") !!}
                    {!! Form::text( "cod_partida" , null , ['class' => 'form-control' , 'placeholder' => 'Codigo Partida' ]) !!}
                </div>
                <div class="col-sm-3">
                    <br>
                    {!! Form::submit('Generar Excel' , ['class' => 'btn btn-success btn-submit-partidas' , 'data-loading-text' => 'Processing...' ]) !!}
                    {!! Form::close() !!}
                </div>
                <div class="col-sm-3">
                    <br>
                </div>
                <div class="col-sm-3">
                    <br>
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
                <h4 class="inline-title">Partidas de Ajuste</h4>
            </div>
            <div class="col-sm-3 title-line-height text-right">
                <div class="btn-group">
                    <a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-body">
        <table id="partida-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
        </table>
    </div>
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/partidas/partida.js') !!}
@endsection