@extends('layout.main') @section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{trans('file.Warehouse Report')}}</h3>
            </div>
            {!! Form::open(['route' => 'report.warehouse', 'method' => 'post']) !!}
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
                                <input type="text" id="created_at_date" class="form-control" autocomplete="off" placeholder="{{trans('Choose Date')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group row">
                        <label class="d-tc mt-2"><strong>{{trans('file.Choose Warehouse')}}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <input type="hidden" name="warehouse_id_hidden" value="{{$warehouse_id}}" />
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                @if(Auth::user()->warehouse_id)
                                    @foreach($lims_warehouse_list as $warehouse)
                                      @if($warehouse->id == Auth::user()->warehouse_id)
                                      <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                      @endif
                                    @endforeach       
                                  @else
                                    @foreach($lims_warehouse_list as $warehouse)
                                      <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="warehouse_id_hidden" value="{{$warehouse_id}}" />
            {!! Form::close() !!}

    
        </div>
    </div>
    <ul class="nav nav-tabs ml-4 mt-3" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" href="#warehouse-sale" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" href="#warehouse-purchase" role="tab" data-toggle="tab">{{trans('file.Purchase')}}</a>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" href="#warehouse-return" role="tab" data-toggle="tab">{{trans('file.return')}}</a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" href="#warehouse-expense" role="tab" data-toggle="tab">{{trans('file.Expense')}}</a>
      </li> --}}
    </ul>
    <!-- //sale report -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="warehouse-sale">
            <div class="table-responsive mb-4">
                <table id="sale-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{trans('file.Date')}}</th>
                            <th>{{trans('file.reference')}} No</th>
                            <th>{{trans('file.customer')}}</th>
                            <th>{{trans('file.product')}}</th>
                            <th>{{trans('file.grand total')}}</th>
                            <th>{{trans('file.Paid')}}</th>
                            <th>{{trans('file.Due')}}</th>
                            <th>{{trans('file.Status')}}</th>
                            <th>{{trans('file.Payment')}}</th>
                            <th>{{trans('file.Sale Note')}}</th>
                            <th>{{trans('file.Staff Note')}}</th>
                            <th>{{trans('file.Payment Note')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>0.00</th>
                            <th>0.00</th>
                            <th>0.00</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="warehouse-return">
            <div class="table-responsive mb-4">
                <table id="return-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{trans('file.Date')}}</th>
                            <th>{{trans('file.reference')}}</th>
                            <th>{{trans('file.customer')}}</th>
                            <th>{{trans('file.Biller')}}</th>
                            <th>{{trans('file.product')}} ({{trans('file.qty')}})</th>
                            <th>{{trans('file.grand total')}}</th>
                            <th>{{trans('file.Return Note')}}</th>
                            <th>{{trans('file.Staff Note')}}</th>
                            <th>{{trans('file.Created By')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>0.00</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #warehouse-report-menu").addClass("active");

    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    var cstartDate = '';
    var cendDate = '';

    var table = '';
    $(function() {
        initializeSalesDatatable();
        initializeReturnDatatable();
    });
    $(function() {
        //Created At
        $('#created_at_date').daterangepicker({
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
            $('#created_at_date span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            cstartDate = start.format('Y-MM-DD');
            cendDate = end.format('Y-MM-DD');
            $('input[name="start_date"]').val(cstartDate);
            $('input[name="end_date"]').val(cendDate);
            initializeSalesDatatable();
            initializeReturnDatatable();
        });
        $('#created_at_date').on('cancel.daterangepicker', function(ev, picker) {
            cstartDate = '';
            cendDate = '';
            $('#created_at_date').val('');
            $('input[name="start_date"]').val(cstartDate);
            $('input[name="end_date"]').val(cendDate);
            initializeSalesDatatable();
            initializeReturnDatatable();
        });
        $('#created_at_date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            $('input[name="start_date"]').val(picker.startDate.format('YYYY-MM-DD'));
            $('input[name="end_date"]').val(picker.endDate.format('YYYY-MM-DD'));
            initializeSalesDatatable();
            initializeReturnDatatable();
        });
    });

    function initializeSalesDatatable() {
        $('.selectpicker').selectpicker('refresh');
        var url = "{{route('report.warehouse.get')}}?type=sale&warehouse_id={{$warehouse_id}}&start_date="+cstartDate+"&end_date="+cendDate+"";
        console.log(url);
        table = $('#sale-table').DataTable( {
            processing: true,
            serverSide: true,
            dom: 'Blfrtip',
            scrollX:        true,
            scrollCollapse: true,
            bFilter: false,
            ajax: {
                url: url,
                type: 'GET',
                data: {
                    'csrf_token':$('meta[name=_token]').attr("content"),
                }
            },
            bDestroy:true,
            ordering: true,
            searching: true,
            searchDelay: 2000,
            stateSave: false,
            deferRender: true,
            smart: true,
            columns: [
                { data: 'created_at', searchable: false },
                { data: 'reference_no', searchable: false, width: '100%'},
                { data: 'customer', width: '100%', searchable: false },
                { data: 'product', width: '100%', searchable: false },
                { data: 'total', width: '100%', searchable: false },
                { data: 'paid', width: '100%', searchable: false },
                { data: 'due', width: '100%', searchable: false },
                { data: 'status', width: '100%', searchable: false },
                { data: 'payment', width: '100%', searchable: false },
                { data: 'sale_note', width: '100%', searchable: false },
                { data: 'staff_note', width: '100%', searchable: false },
                { data: 'payment_note', width: '100%', searchable: false },
            ],
            "order": [],
            // 'columnDefs': [
            //     {
            //         "orderable": false,
            //         'targets': 0
            //     },
            //     {
            //         'render': function(data, type, row, meta){
            //             if(type === 'display'){
            //                 data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
            //             }

            //            return data;
            //         },
            //         'checkboxes': {
            //            'selectRow': true,
            //            'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
            //         },
            //         'targets': [0]
            //     }
            // ],
            // 'select': { style: 'multi',  selector: 'td:first-child'},
            'lengthMenu': [[100, 200, 300, -1], [100, 200, 300, "All"]],
            //dom: '<"row"lfB>rtip',
            buttons: [
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer:true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer:true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_sale(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_sale(dt, false);
                    },
                    footer:true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function () {
                var api = this.api();
                datatable_sum_sale(api, false);
            }
        } );

        function datatable_sum_sale(dt_selector, is_calling_first) {
            if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
                var rows = dt_selector.rows( '.selected' ).indexes();

                $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
                $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
                $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            }
            else {
                $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
                $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
                $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            }
        }
    }

    function initializeReturnDatatable() {
        $('.selectpicker').selectpicker('refresh');
        var url = "{{route('report.warehouse.get')}}?type=return&warehouse_id={{$warehouse_id}}&start_date="+cstartDate+"&end_date="+cendDate+"";
        console.log(url);
        table = $('#return-table').DataTable( {
            processing: true,
            serverSide: true,
            dom: 'Blfrtip',
            scrollX:        true,
            scrollCollapse: true,
            bFilter: false,
            ajax: {
                url: url,
                type: 'GET',
                data: {
                    'csrf_token':$('meta[name=_token]').attr("content"),
                }
            },
            bDestroy:true,
            ordering: true,
            searching: true,
            searchDelay: 2000,
            stateSave: false,
            deferRender: true,
            smart: true,
            columns: [
                { data: 'created_at', searchable: false },
                { data: 'reference_no', searchable: false, width: '100%'},
                { data: 'customer', width: '100%', searchable: false},
                { data: 'biller', width: '100%', searchable: false},
                { data: 'product', width: '100%', searchable: false },
                { data: 'total', width: '100%', searchable: false},
                { data: 'return_note', width: '100%', searchable: false},
                { data: 'staff_note', width: '100%', searchable: false},
                { data: 'created_by', width: '100%', searchable: false},
            ],
            "order": [],
            'lengthMenu': [[100, 200, 300, -1], [100, 200, 300, "All"]],
            //dom: '<"row"lfB>rtip',
            buttons: [
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
                    },
                    footer:true
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
                    },
                    footer:true
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported-sale)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum_return(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum_return(dt, false);
                    },
                    footer:true
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                }
            ],
            drawCallback: function () {
                var api = this.api();
                datatable_sum_return(api, false);
            }
        } );

        function datatable_sum_return(dt_selector, is_calling_first) {
            if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
                var rows = dt_selector.rows( '.selected' ).indexes();

                $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            }
            else {
                $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            }
        }
    }



</script>

<style>
    .dataTables_filter {
        display: none!important;
    }
</style>
@endsection