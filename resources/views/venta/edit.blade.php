<div class="modal fade" id="ventaUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditVenta" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Venta</h4>
            </div>
            <form id="edit-venta-form" class="form-horizontal" role="form" method="POST" action="{{ url('') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Tipo de Venta</label>
                        <div class="col-md-6">
                            <select class="form-control" id='tipo_venta_id' name="tipo_venta_id" value="{{ old('role')}}">
                                @foreach ($tipo_ventas as $tipo_venta)
                                <option value="{{$tipo_venta->id}}">{{ $tipo_venta->tipo_venta}}</option>;
                                @endforeach
                            </select>
                            <span id="tipo_venta_id-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" id="editClassButton">
                            <i  class="fa fa-btn fa-user"></i>Editar Venta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>