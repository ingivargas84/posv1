<div class="modal fade" id="ingresoproductoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditIngresoProducto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Ingreso de Productos</h4>
            </div>
            <form id="edit-ingresoproducto-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    
                    <div class="form-group{{ $errors->has('serie_factura') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Serie de la Factura</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="serie_factura" value="{{ old('serie_factura') }}">
                            <span id="serie_factura-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('serie_factura'))
                            <span class="help-block">
                                <strong>{{ $errors->first('serie_factura') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('num_factura') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Numero de Factura</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="num_factura" value="{{ old('num_factura') }}">
                            <span id="num_factura-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('num_factura'))
                            <span class="help-block">
                                <strong>{{ $errors->first('num_factura') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('fecha_factura') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Fecha de Factura</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id= "fecha_factura" name="fecha_factura" value="{{ old('fecha_factura') }}">
                            <span id="fecha_factura-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('fecha_factura'))
                            <span class="help-block">
                                <strong>{{ $errors->first('fecha_factura') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('proveedor_id') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Proveedor</label>
                        <div class="col-md-6">
                           <select class="selectpicker data" id='proveedor_id' name="proveedor_id" value="{{ old('proveedor_id')}}" data-live-search="true">
                            @foreach ($proveedores as $proveedor)
                            <option value="{{$proveedor->id}}">{{ $proveedor->nombre_comercial }}</option>;
                            @endforeach
                        </select>
                        <span id="proveedor_id-error" class="help-block hidden">
                            <strong></strong>
                        </span>
                        @if ($errors->has('proveedor_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('proveedor_id') }}</strong>
                        </span>
                        @endif
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