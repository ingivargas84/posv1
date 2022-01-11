<div class="modal fade" id="productoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditProducto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Producto</h4>
            </div>
            <form id="edit-producto-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">

                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('codigobarra') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Código de Barra</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="codigobarra" value="{{ old('codigobarra') }}">
                            <span id="codigobarra-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('codigobarra'))
                            <span class="help-block">
                                <strong>{{ $errors->first('codigobarra') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('prod_nombre') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Nombre</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="prod_nombre" value="{{ old('prod_nombre') }}">
                            <span id="prod_nombre-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('prod_nombre'))
                            <span class="help-block">
                                <strong>{{ $errors->first('prod_nombre') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('precio_venta') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Precio Venta</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="precio_venta" value="{{ old('precio_venta') }}">
                            <span id="precio_venta-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('precio_venta'))
                            <span class="help-block">
                                <strong>{{ $errors->first('precio_venta') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Estado Producto</label>
                        <div class="col-md-6">
                            <select class="form-control" id='tipo_venta_id' name="tipo_venta_id" value="{{ old('role')}}">
                                @foreach ($status as $data)
                                <option value="{{$data->id}}">{{ $data->edo_producto}}</option>;
                                @endforeach
                            </select>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Editar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>