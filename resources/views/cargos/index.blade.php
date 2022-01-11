@extends('layouts.app')
@section('content')
<div class="user-created-message alert alert-dismissible fade in hidden" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    <p></p>
</div>
@if ( isset( $user_created ) )
<div class="alert alert-success alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    {{ $user_created  }}
</div>
@endif
<div class="panel panel-default">
    <div class="panel panel-heading">
        <div class="row">
            <div class="col-sm-3 title-line-height"></div>
            <div class="col-sm-6 text-center">
                <h4 class="inline-title">Cargos</h4>
            </div>
            <div class="col-sm-3 title-line-height text-right">
                <div class="btn-group">
                    <a class='delete-records-btn btn btn-danger btn-title m-r-15 border-radius' href="#" style="display: none;">Delete</a>
                    <button class='btn btn-primary btn-title border-radius' id="createUser" data-target='#userModal' data-toggle='modal'>Add new</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-body">
        <table id="cargo-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" ellspacing="0" width="100%">
        </table>
    </div>
</div>
@endsection
@section('scripts')
{!! HTML::script('/js/cargo/cargo.js') !!}
<!-- <script src="{{ URL::to( "/js/cargo/cargo.js" ) }}"></script> -->
@endsection