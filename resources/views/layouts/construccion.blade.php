@extends('layouts.app')
@section('content')

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
                <h1 class="inline-title">En Construcción!!!</h1>
            </div>
            
        </div>
    </div>
    
</div>
@endsection
