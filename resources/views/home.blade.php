@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" style="
    text-align: center;">
    <div class="col-md-10 col-md-offset-1" style="
    text-align: center;">
    <div class="panel panel-default" style="
    text-align: center;">
    <div class="panel-heading" style="font-size:20px;">Sistema de Punto de Venta</div>

    <div class="panel-body">
    
      <div class="row">
        <div class="col-lg-6 col-xs-6">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fas fa-cash-register"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Ventas Hoy</span>
              <span class="info-box-number">Q. {{number_format((float) $ventas[0]->total, 2) }}</span>
            </div>
          </div>
        </div>

      <div class="col-lg-6 col-xs-6">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Compras Hoy</span>
            <span class="info-box-number">Q. {{number_format((float) $compras[0]->total, 2) }}</span>
          </div>
        </div>
      </div>
  </div> 
  {{-- sales chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Ventas diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-success" id="sales_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="sales-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>

{{-- purchase chart --}}
<div class="row">
  <div class="col-sm-12">
    <div class="box box-warning">
      <div class="box-header with-border">
        <h3 class="box-title">Compras diarias del mes</h3>
        <div class="box-tools pull-right">
          <h4 style="margin: 0"><span class="label label-warning" id="purchase_month_label"></span></h4>
        </div>
      </div>
      <div class="box-body">
        <div id="purchase-graph" style="height: 175px;"></div>
      </div>
    </div>
  </div>
</div>   
</div>
</div>
</div>
</div>
</div>
@endsection
@section('scripts')

<script defer>

  $(document).ready(function(){
    var date = new Date();
    var month = date.toLocaleDateString('es-ES', {month: 'long'});
    var sales_url = "{{ route('dashboard.salesData') }}";
    var purchase_url = "{{ route('dashboard.purchaseData') }}";

    $('#sales_month_label').text(month);
    $('#purchase_month_label').text(month);

  $.ajax({
    type: "GET",
    headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
    url: sales_url,
    dataType: 'json',
    success: function(data){
      for (let i = 0; i < data.length; i++) {
        var newDate = new Date(data[i].fecha.replace(/-/g, '\/'));
        data[i].fecha = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
      }

      for (let i = 0; i < data.length; i++) {
        data[i].amount = parseInt(data[i].amount).toFixed(2);
      }

      new Morris.Bar({
        element: 'sales-graph',
        data: data,
        xkey: 'fecha',
        ykeys: ['amount'],
        labels: ['Vendido'],
        resize: true,
        preUnits: 'Q. ',
        barColors: ['#00a65a'],
        hideHover: true,
      });
    },
    error: function(){
      console.log('error al obtener datos de ventas');
    }
  });


  $.ajax({
    type: "GET",
    headers: { 'X-CSRF-TOKEN': $('#tokenReset').val() },
    url: purchase_url,
    dataType: 'json',
    success: function(data){

      for (let i = 0; i < data.length; i++) {
        var newDate = new Date(data[i].fecha.replace(/-/g, '\/'));
        data[i].fecha = newDate.toLocaleDateString('es-ES', {day: 'numeric', month: 'long'});
      }

      for (let i = 0; i < data.length; i++) {
        data[i].amount = parseFloat(data[i].amount).toFixed(2);
      }

      new Morris.Bar({
        element: 'purchase-graph',
        data: data,
        xkey: 'fecha',
        ykeys: ['amount'],
        labels: ['Comprado'],
        resize: true,
        preUnits: 'Q. ',
        barColors: ['#f39c12'],
        hideHover: true,
      });
    },
    error: function(){
      console.log('Error al obtener datos de compras');
    }
  });
});
</script>
@endsection