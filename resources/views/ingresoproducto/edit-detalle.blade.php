<div class="modal fade" id="ingresodetalleUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditIngresoProducto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Ingreso de Productos</h4>
            </div>
            <form id="edit-ingresodetalle-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('existencias') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Existencias</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="existencias" value="{{ old('existencias') }}">
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('precio_compra') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Precio Compra</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="precio_compra" value="{{ old('precio_compra') }}">
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('precio_venta') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Precio Venta</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id= "precio_venta" name="precio_venta" value="{{ old('precio_venta')}}">
                            <span id="precio_venta-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Editar Ingreso de Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>