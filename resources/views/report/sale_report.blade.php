@extends('layout.main') @section('content')

@if(empty($product_name))
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{'No Data exist between this date range!'}}</div>
@endif

<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{trans('file.Sale Report')}}</h3>
                <h2 style="text-align:center;">{{$start_date}} To {{$end_date}}</h2>
            </div>
            {!! Form::open(['route' => 'report.sale', 'method' => 'post']) !!}
            <div class="row mb-3">
                <div class="col-md-5 offset-md-1 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group" style="display: none;">
                                <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" required />
                                <input type="hidden" name="start_date" value="{{$start_date}}" />
                                <input type="hidden" name="end_date" value="{{$end_date}}" />
                            </div>
                            <div class="input-group date datepicker">
                                <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
                                <input type="text" id="lead_created_date" class="form-control" autocomplete="off" placeholder="{{trans('Choose Date')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Warehouse')}}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <input type="hidden" name="warehouse_id_hidden" value="{{$warehouse_id}}" />
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                @if(Auth::user()->warehouse_id)
                                    @foreach($lims_warehouse_list as $warehouse)
                                      @if($warehouse->id == Auth::user()->warehouse_id)
                                      <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                      @endif
                                    @endforeach       
                                  @else
                                    <option value="0">{{trans('file.All Warehouse')}}</option>
                                    @foreach($lims_warehouse_list as $warehouse)
                                      <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-4">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="table-responsive">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Product Name')}}</th>
                    <th>{{trans('file.Sold Amount')}}</th>
                    <th>{{trans('file.Sold Qty')}}</th>
                    <th>{{trans('file.In Stock')}}</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($product_name))
                @foreach($product_id as $key => $pro_id)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$product_name[$key]}}</td>
                    <?php
                        if($warehouse_id == 0){
                            if($variant_id[$key]) {
                                $sold_price = DB::table('product_sales')->where([
                                    ['product_id', $pro_id],
                                    ['variant_id', $variant_id[$key] ]
                                ])->whereDate('created_at','>=', $start_date)
                                  ->whereDate('created_at','<=', $end_date)
                                  ->sum('total');

                                $product_sale_data = DB::table('product_sales')->where([
                                    ['product_id', $pro_id],
                                    ['variant_id', $variant_id[$key] ]
                                ])->whereDate('created_at','>=', $start_date)
                                  ->whereDate('created_at','<=', $end_date)
                                  ->get();
                            }
                            else {
                                $sold_price = DB::table('product_sales')->where('product_id', $pro_id)
                                ->whereDate('created_at','>=', $start_date)->whereDate('created_at','<=', $end_date)->sum('total');

                                $product_sale_data = DB::table('product_sales')->where('product_id', $pro_id)->whereDate('created_at','>=', $start_date)->whereDate('created_at','<=', $end_date)->get();
                            }
                        }
                        else{
                            if($variant_id[$key]) {
                                $sold_price = DB::table('sales')
                                    ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                        ['product_sales.product_id', $pro_id],
                                        ['variant_id', $variant_id[$key] ],
                                        ['sales.warehouse_id', $warehouse_id]
                                    ])->whereDate('sales.created_at','>=', $start_date)->whereDate('sales.created_at','<=', $end_date)->sum('total');
                                $product_sale_data = DB::table('sales')
                                    ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                        ['product_sales.product_id', $pro_id],
                                        ['variant_id', $variant_id[$key] ],
                                        ['sales.warehouse_id', $warehouse_id]
                                    ])->whereDate('sales.created_at','>=', $start_date)->whereDate('sales.created_at','<=', $end_date)->get();
                            }
                            else {
                                $sold_price = DB::table('sales')
                                    ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                        ['product_sales.product_id', $pro_id],
                                        ['sales.warehouse_id', $warehouse_id]
                                    ])->whereDate('sales.created_at','>=', $start_date)->whereDate('sales.created_at','<=', $end_date)->sum('total');
                                $product_sale_data = DB::table('sales')
                                    ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                        ['product_sales.product_id', $pro_id],
                                        ['sales.warehouse_id', $warehouse_id]
                                    ])->whereDate('sales.created_at','>=', $start_date)->whereDate('sales.created_at','<=', $end_date)->get();
                            }
                        }
                        $sold_qty = 0;
                        foreach ($product_sale_data as $product_sale) {
                            $unit = DB::table('units')->find($product_sale->sale_unit_id);
                            if($unit){
                                if($unit->operator == '*')
                                    $sold_qty += $product_sale->qty * $unit->operation_value;
                                elseif($unit->operator == '/')
                                    $sold_qty += $product_sale->qty / $unit->operation_value;
                            }
                            else
                                $sold_qty += $product_sale->qty;
                        }
                    ?>
                    <td>{{number_format((float)$sold_price, 2, '.', '')}}</td>
                    <td>{{$sold_qty}}</td>
                    <td>{{$product_qty[$key]}}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <th></th>
                <th>Total</th>
                <th>0.00</th>
                <th>0</th>
                <th>0</th>
            </tfoot>
        </table>
    </div>
</section>


<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #sale-report-menu").addClass("active");

    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $('#report-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                'checkboxes': {
                   'selectRow': true,
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 2 ).footer() ).html(dt_selector.cells( rows, 2, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 2 ).footer() ).html(dt_selector.column( 2, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.column( 3, {page:'current'} ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
        }
    }

$(".daterangepicker-field").daterangepicker({
  callback: function(startDate, endDate, period){
    var start_date = startDate.format('YYYY-MM-DD');
    var end_date = endDate.format('YYYY-MM-DD');
    var title = start_date + ' To ' + end_date;
    $(this).val(title);
    $('input[name="start_date"]').val(start_date);
    $('input[name="end_date"]').val(end_date);
  }
});

//Created At
$('#lead_created_date').daterangepicker({
    autoUpdateInput: false,
    ranges: {
        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    locale: {
        cancelLabel: '{{ trans("Clear") }}'
    }
}, function (start, end) {
    $('#lead_created_date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    cstartDate = start.format('Y-MM-DD');
    cendDate = end.format('Y-MM-DD');
    $('input[name="start_date"]').val(cstartDate);
    $('input[name="end_date"]').val(cendDate);
});
$('#lead_created_date').on('cancel.daterangepicker', function(ev, picker) {
    cstartDate = '';
    cendDate = '';
    $('#lead_created_date').val('');
    $('input[name="start_date"]').val(cstartDate);
    $('input[name="end_date"]').val(cendDate);
});
$('#lead_created_date').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    $('input[name="start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
    $('input[name="end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
});

</script>
@endsection