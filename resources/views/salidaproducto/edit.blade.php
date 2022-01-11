<div class="modal fade" id="salidaproductoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditSalidaProducto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Salida de Productos</h4>
            </div>
            <form id="edit-salidaproducto-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('tipo_salida_id') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Tipo de Salida</label>
                        <div class="col-md-6">
                            <select class="selectpicker data" id='tipo_salida_id' name="tipo_salida_id" value="{{ old('company')}}" data-live-search="true">
                                @foreach ($tipo_salidas as $tipo_salida)
                                <option value="{{$tipo_salida->id}}">{{ $tipo_salida->tipo_salida}}</option>;
                                @endforeach
                            </select>
                            <span id="tipo_salida_id-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('tipo_salida_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tipo_salida_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Editar Salida de Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>