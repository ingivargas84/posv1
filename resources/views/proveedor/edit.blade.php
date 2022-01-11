<div class="modal fade" id="proveedorUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditProveedor" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Producto</h4>
            </div>
            <form id="edit-proveedor-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('nombre_comercial') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Nombre Comercial</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="nombre_comercial" value="{{ old('nombre_comercial') }}">
                            <span id="nombre_comercial-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('nombre_comercial'))
                            <span class="help-block">
                                <strong>{{ $errors->first('nombre_comercial') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('telefonos') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Teléfono</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="telefonos" value="{{ old('telefonos') }}">

                            <span id="telefonos-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('telefonos'))
                            <span class="help-block">
                                <strong>{{ $errors->first('telefonos') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Editar Proveedor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>