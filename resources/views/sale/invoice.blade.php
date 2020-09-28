<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('logo', $general_setting->site_logo)}}" />
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 16px;
            line-height: 24px;
            font-family: 'system-ui';
            text-transform: capitalize;
            color: rgb(0,0,0, 100)!important;
            font-weight: 700;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 7px 0;width: 50%;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media print {
            * {
                font-size:12px;
                line-height: 20px;
            }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            @page { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; } 
        }
    </style>
  </head>
<body>

<div style="max-width:400px;margin:0 auto">
    @if(preg_match('~[0-9]~', url()->previous()))
        @php $url = '../../pos'; @endphp
    @else
        @php $url = url()->previous(); @endphp
    @endif
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="{{$url}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{trans('file.Back')}}</a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> {{trans('file.Print')}}</button></td>
            </tr>
        </table>
        <br>
    </div>
        
    <div id="receipt-data">
        <div class="centered">
            <img src="https://www.levoilescarfs.com/wp-content/uploads/2020/04/logo.jpg" width="60%">
            <h2>Branch: {{$lims_biller_data->company_name}}</h2>
            
        </div>
        <p>{{trans('file.Date')}}: {{$lims_sale_data->created_at}}<br>
            {{trans('file.reference')}}: {{$lims_sale_data->reference_no}}<br>
            {{trans('file.customer')}}: {{$lims_customer_data->name}}<br>
            Cashier: {{$lims_sale_data->user->name}}
        </p>
        <table>
            <tbody>
                <thead>
                    <tr>
                        <th colspan="2" style="text-align:left;">Product</th>
                        <th colspan="2" style="text-align:right;">Price</th>
                    </tr>
                </thead>
                @foreach($lims_product_sale_data as $product_sale_data)
                @php 
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id != null) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$lims_product_data->code . '-' . $variant_data->name.']';
                    }
                    else
                        $product_name = $lims_product_data->name . ' ['.$lims_product_data->code.'] ';
                @endphp
                <tr><td colspan="2">{{$product_name}}<br>{{$product_sale_data->qty}} x {{number_format((float)($product_sale_data->total / $product_sale_data->qty), 2, '.', '')}}
                    <br>
                </td>
                    <td style="text-align:right;vertical-align:bottom">{{number_format((float)$product_sale_data->total, 2, '.', '')}}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>

                <tr>
                    <th colspan="2">{{trans('file.Total')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->total_price, 2, '.', '')}}</th>
                </tr>
                @if($lims_sale_data->order_tax)
                <tr>
                    <th colspan="2">{{trans('file.Order Tax')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->order_tax, 2, '.', '')}}</th>
                </tr>
                @endif
                @if($lims_sale_data->order_discount)
                <tr>
                    <th colspan="2">{{trans('file.Order Discount')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->order_discount, 2, '.', '')}}</th>
                </tr>
                @endif
                @if($lims_sale_data->coupon_discount)
                <tr>
                    <th colspan="2">{{trans('file.Coupon Discount')}} ({{$lims_sale_data->coupon->code}})</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->coupon_discount, 2, '.', '')}}</th>
                </tr>
                @endif
                @if($lims_sale_data->shipping_cost)
                <tr>
                    <th colspan="2">{{trans('file.Shipping Cost')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->shipping_cost, 2, '.', '')}}</th>
                </tr>
                @endif
                <tr>
                    <th colspan="2">{{trans('file.grand total')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->grand_total, 2, '.', '')}}</th>
                </tr>
            </tfoot>
        </table>
        <table>
            <tbody>
                @foreach($lims_payment_data as $payment_data)
                <tr style="background-color:#ddd;">
                    <td style="padding: 5px;width:30%">{{trans('file.Paid By')}}: {{$payment_data->paying_method}}</td>
                    <td style="padding: 5px;width:40%">{{trans('file.Paid Amount')}}: {{number_format((float)$payment_data->amount + (float)$payment_data->change, 2, '.', '')}}</td>
                    <td style="padding: 5px;width:30%">{{trans('file.Change')}}: {{number_format((float)$payment_data->change, 2, '.', '')}}</td>
                </tr>
                <tr><td class="centered" colspan="3">El Marghani Branch: 126 El-Marghany st., next to Shawermer | Tel: 0222913400 </td></tr>
                <tr><td class="centered" colspan="3">Hegaz Branch: 7 Ali Abd El-Razek st., parallel to Ammar Ibn Yasser st | Tel: 0226212206 </td></tr>
                <tr><td class="centered" colspan="3">Abbas Branch: 35 Ezzat Salama st., end of Hussein Heikal st., Abbas El-Akkad | Tel: 0222726332 </td></tr>
                <tr><td class="centered" colspan="3">El Nozha Branch: 4 El Nozha St.,Infront of Mobil gas station, Nasr City | Tel: 0224182448 </td></tr>
                <tr><td class="centered" colspan="3">Galleria Mall Branch: S 90th st. Galleria Mall beside Dunkin' Donuts, front of Future university  | Tel: 01050092640 </td></tr>
                <tr><td class="centered" colspan="3">Point 90 Branch: S 90th st. Point 90 Mall beside H&M, front of American university | Tel: 01050092670   </td></tr>
                <tr><td class="centered" colspan="3">El Mohandessen Branch: 41 Shehab st. from Gamat El Dwal El Arabia St. Mohandessen. | Tel: 01050092690</td></tr>
                <tr><td class="centered" colspan="3">{{trans('file.Thank you for shopping with us. Please come again')}}</td></tr>
                @endforeach
                <tr><td class="centered" colspan="3">ملحوظه هامه: جميع الإكسسوارات والباديهات لا ترد ولا تستبدل</td></tr>
                <tr><td class="centered" colspan="3">المنتجات المباعه ترد خلال يومين وتستبدل خلال 14 يوم</td></tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    function auto_print() {     
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
