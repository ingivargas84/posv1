<div class="modal fade" id="cuentaxCobrarModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditProducto" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Registro de Pago para Cuentas por Cobrar</h4>
            </div>
            <form id="edit-producto-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('empleado_id') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Empleado:</label>
                        <div class="col-md-6">
                            <select class="selectpicker data" id='empleado_id' name="empleado_id" value="{{ old('company')}}" data-live-search="true">
                                <option value="0" selected>Seleccione un empleado </option>;
                                @foreach ($empleados as $empleado)
                                <option value="{{$empleado->id}}">{{ $empleado->emp_nombres}}</option>;
                                @endforeach
                            </select>
                            <span id="empleado_id-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('empleado_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('empleado_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('monto') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Monto Q.:</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="monto" value="{{ old('monto') }}">
                            <span id="monto-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('monto'))
                            <span class="help-block">
                                <strong>{{ $errors->first('monto') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('saldo') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Saldo Q.</label>
                        <div class="col-md-6">
                            <input type="text" id="saldo" class="form-control" name="saldo" disabled>
                            <span id="saldo-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('saldo'))
                            <span class="help-block">
                                <strong>{{ $errors->first('saldo') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Agregar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>