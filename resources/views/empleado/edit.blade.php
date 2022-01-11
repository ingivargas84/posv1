<div class="modal fade" id="empleadoUpdateModal" tabindex="-1" role="dialog" aria-labelledby="userEditModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="closeEditEmpleado" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="userEditModalLabel">Editar Empleado</h4>
            </div>
            <form id="edit-empleado-form" class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/update') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>
                <div class="modal-body">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('emp_direccion') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Dirección</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="emp_direccion" value="{{ old('emp_direccion') }}">
                            <span id="emp_direccion-error" class="help-block hidden">
                                <strong></strong>
                            </span>
                            @if ($errors->has('emp_direccion'))
                            <span class="help-block">
                                <strong>{{ $errors->first('emp_direccion') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('emp_telefonos') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Teléfonos</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control" name="emp_telefonos" value="{{ old('emp_telefonos') }}">

                            <span id="emp_telefonos-error" class="help-block hidden">
                                <strong></strong>
                            </span>

                            @if ($errors->has('emp_telefonos'))
                            <span class="help-block">
                                <strong>{{ $errors->first('emp_telefonos') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="form-group{{ $errors->has('cargo_id') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Cargo</label>
                        <div class="col-md-6">
                         <select class="selectpicker data" id='cargo_id' name="cargo_id" value="{{ old('cargo_id')}}" data-live-search="true">
                            @foreach ($cargos as $cargo)
                            <option value="{{$cargo->id}}">{{ $cargo->cargo}}</option>;
                            @endforeach
                        </select>
                        <span id="num_factura-error" class="help-block hidden">
                            <strong></strong>
                        </span>
                        @if ($errors->has('cargo_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('cargo_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div> -->
                <div class="modal-footer">
                    <button type="button" id="closeEditUser2" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" id="editClassButton">
                        <i  class="fa fa-btn fa-user"></i>Editar Empleado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>