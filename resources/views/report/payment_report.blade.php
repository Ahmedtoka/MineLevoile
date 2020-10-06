@extends('layout.main') @section('content')

<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{trans('file.Payment Report')}}</h3>
                <h2 class="text-center">{{$start_date}} To {{$end_date}}</h2>
            </div>
            {!! Form::open(['route' => 'report.paymentByDate', 'method' => 'post']) !!}
            <div class="col-md-12 mt-4">
        
                <div class="col-md-6 mt-3">
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
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="table-responsive mb-4">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.Payment Reference')}} </th>
                    <th>{{trans('file.Sale Reference')}}</th>
                    <th>{{trans('file.Purchase Reference')}}</th>
                    <th>{{trans('file.Paid By')}}</th>
                    <th>{{trans('file.Amount')}}</th>
                    <th>{{trans('file.Created By')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_payment_data as $payment)
                <?php 
                    $sale = DB::table('sales')->find($payment->sale_id);
                    $purchase = DB::table('purchases')->find($payment->purchase_id);
                    $user = DB::table('users')->find($payment->user_id);
                ?>
                <tr>
                    <td></td>
                    <td>{{date($general_setting->date_format, strtotime($payment->created_at->toDateString())) . ' '. $payment->created_at->toTimeString()}}</td>
                    <td>{{$payment->payment_reference}}</td>
                    <td>@if($sale){{$sale->reference_no}}@endif</td>
                    <td>@if($purchase){{$purchase->reference_no}}@endif</td>
                    <td>{{$payment->paying_method}}</td>
                    <td>{{$payment->amount}}</td>
                    <td>{{$user->name}}<br>{{$user->email}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li#payment-report-menu").addClass("active");

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
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            }
        ],
    } );

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