@extends('layout.top-head') @section('content')

<style type="text/css">
    * {
        font-size: 16px;
        line-height: 24px;
        font-family: 'system-ui';
        text-transform: capitalize;
        color: rgb(0,0,0, 100)!important;
        font-weight: 700;
    }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Close Day')}} - {{$register->id}} - {{$register->branch->name}} - {{$register->created_at}}</h4>
                    </div>
                    @if($register->register_close_amount)
                    <div class="card-body" id="closeRegister">
				      	<div class="row">
					        <div class="col-sm-12">
					          <table class="table">
					            <tbody>
					           	{{-- <tr>
					              <td>
					                رصيد اول الدرج
					              </td>
					              <td>
					                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->open_amount}}</span>
					              </td>
					            </tr> --}}
					            <tr>
					              <td>
					                Total Sales
					              </td>
					              <td>
					                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_pure_sale}}</span>
					              </td>
					            </tr>
					            <tr>
					              <td>
					                Visa Sales
					              </td>
					              <td>
					                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_card}}</span>
					              </td>
					            </tr>
					            <tr>
					              <td>
					                Cash Sales
					              
					              </td><td>
					                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_cash}}</span>
					              </td>
					            </tr>
					            {{-- <tr class="success">
					              <th>
					                إجمالي مصاريف الفرع             </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_expense}}</span></b><br>
					                <small>
					                </td>
					            </tr> --}}
					            <tr class="success">
					              <th>
					                Total Cash Returns             </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_cash_refund}}</span></b><br>
					                <small>
					                </td>
					            </tr>
					            <tr class="success">
					              <th>
					                Total Visa Returns             </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_card_refund}}</span></b><br>
					                <small>
					                </td>
					            </tr>
					            <tr class="success">
					              <th>
					                Total Returns             </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_refund}}</span></b><br>
					                <small>
					                </td>
					            </tr>
					            
					            <tr class="success">
					              <th>
					                Total Cash In Register 
					            </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->open_amount + $register_details->total_cash - $register_details->total_cash_refund - $register_details->total_expense }}</span></b>
					              </td>
					            </tr>
					            <tr class="success">
					              <th>
					                Total Visa In Register 
					              </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_card - $register_details->total_card_refund }}</span></b>
					              </td>
					            </tr>
					            <tr class="success">
					              <th>
					              	No. of Visa receipts
					              </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true">{{$register_details->total_card_slips}}</span></b>
					              </td>
					            </tr>
					            @if($register->close_status == 'negative')
					            <tr class="success" style="color:red">
					              <th>
					                Deficit Amount
					              </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register->close_status_amount}}</span></b>
					              </td>
					            </tr>
					            @endif

					            @if($register->close_status == 'positive')
					            <tr class="success" style="color:green">
					              <th>
					                Excess Amount
					              </th>
					              <td>
					                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register->close_status_amount}}</span></b>
					              </td>
					            </tr>
					            @endif
					          </tbody></table>
					        </div>
				      	</div>
                    </div>
                    @endif
            	</div>
        	</div>
    	</div>
    </div>
</section>


@endsection