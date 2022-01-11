@extends('layouts.app')

@section('content')
<div class="container">
   <div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel panel-heading">
                <div class="row">
                    <div class="col-sm-3 title-line-height"></div>
                    <div class="col-sm-6 text-center">
                    <h4 class="inline-title">Reporte de Existencias de Productos</h4>
                    </div>
                    <div class="col-sm-3 title-line-height text-right">
                        <div class="btn-group">
                            <a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Delete</a>
                            <a class="btn btn-success" href="{{URL::to('/pdf_existenciaprod')}}" target= "_blank">Generar Excel</a>

                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-body">
                <table id="existenciaprod-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/existenciaprod/existenciaprod.js') !!}
@endsection