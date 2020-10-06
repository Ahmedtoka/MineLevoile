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
                        <h4>{{trans('file.Close Day')}}</h4>
                    </div>
                    <form action="{{route('register.close.post', $register->id)}}" method="POST">
                    	@csrf
	                    @if(!$register->register_close_amount)
	                    <div class="card-body">
	                    	<div class="row">
	                    		<div class="container">
	                    			<div class="col-md-6 offset-md-3" style="text-align:center;">
	                    				<h3>ادخل مبلغ الدرج</h3>
	                    				<em>كاش</em>
	                    				<div class="form-group">
	                    					<input type="text" name="register_close_amount" class="form-control">
	                    				</div>
	                    				<div class="form-group">
	                    					<button class="btn btn-primary" type="submit" name="close_register" value="save-cash-on-hand">{{trans('file.submit')}}</button>
	                    				</div>
	                    			</div>
	                    		</div>
	                    	</div>
	                    </div>
	                    @endif

	                    @if($register->register_close_amount)
	                    <div class="card-body" id="closeRegister">
					      	<div class="row">
						        <div class="col-sm-12">
						          <table class="table">
						            <tbody>
						           	<tr>
						              <td>
						                رصيد اول الدرج
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->open_amount}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                إجمالي المبيعات
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_pure_sale}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                مبيعات الفيزا
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_card}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                مبيعات الكاش
						              
						              </td><td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_cash}}</span>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						                إجمالي مصاريف الفرع             </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_expense}}</span></b><br>
						                <small>
						                </td>
						            </tr>
						            <tr class="success">
						              <th>
						                إجمالي مرتجعات الكاش             </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_cash_refund}}</span></b><br>
						                <small>
						                </td>
						            </tr>
						            <tr class="success">
						              <th>
						                إجمالي مرتجعات الفيزا             </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_card_refund}}</span></b><br>
						                <small>
						                </td>
						            </tr>
						            <tr class="success">
						              <th>
						                إجمالي المرتجعات             </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true" style="color:red">L.E {{$register_details->total_refund}}</span></b><br>
						                <small>
						                </td>
						            </tr>
						            
						            <tr class="success">
						              <th>
						                إجمالي الكاش في الدرج 
						            </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->open_amount + $register_details->total_cash - $register_details->total_cash_refund - $register_details->total_expense }}</span></b>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						                إجمالي الفيزا في الدرج 
						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_card - $register_details->total_card_refund }}</span></b>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						                (مجموع الدرج (كاش + فيزا

						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_sale + $register_details->open_amount - $register_details->total_expense}}</span></b>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						              	عدد شيكات الفيزا
						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">{{$register_details->total_card_slips}}</span></b>
						              </td>
						            </tr>
						            @if($register->close_status == 'negative')
						            <tr class="success" style="color:red">
						              <th>
						                رصيد العجز
						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register->close_status_amount}}</span></b>
						              </td>
						            </tr>
						            @endif

						            @if($register->close_status == 'positive')
						            <tr class="success" style="color:green">
						              <th>
						                رصيد الزيادة
						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register->close_status_amount}}</span></b>
						              </td>
						            </tr>
						            @endif
						          </tbody></table>
						        </div>
					      	</div>

					      	<div class="row">
						        <div class="col-sm-4">
						          <div class="form-group">
						            <label for="total_cash">إجمالي الكاش:*</label>
						              <input class="form-control input_number" required="" placeholder="Total Cash" name="total_cash" type="text" value="{{$register_details->total_cash - $register_details->total_cash_refund + $register_details->open_amount - $register_details->total_expense}}" id="total_cash" disabled>
						          </div>
						        </div>
						        <div class="col-sm-4">
						          <div class="form-group">
						            <label for="total_card_slips">إجمالي الفيزا:*</label> <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Total number of card payments used in this register" data-html="true" data-trigger="hover"></i>              <input class="form-control" required="" placeholder="Total Card Slips" name="total_card_slips" type="text" value="{{$register_details->total_card - $register_details->total_card_refund}}" id="total_card_slips"disabled>
						          </div>
						        </div> 
						        <div class="col-sm-4">
						          <div class="form-group">
						            <label for="closing_amount">أدخل مبلغ التوريد الكاش:* لا يزيد عن {{$register->register_close_amount}} جنيه</label> <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Total number of cheques used in this register" data-html="true" data-trigger="hover"></i> <input class="form-control" required="" placeholder="Closing Cash Amount" name="closing_amount" type="number" value="" max="{{$register->register_close_amount}}" step=".01">
						          </div>
						        </div> 
						        <div class="col-sm-12">
						          <div class="form-group">
						            <label for="closing_note">ملاحظات:</label>
						              <textarea class="form-control" placeholder="Closing Note" rows="3" name="closing_note" cols="50" id="closing_note"></textarea>
						          </div>
						          <div class="form-group">
	                					<button class="btn btn-primary" onclick="window.print()" type="submit" name="close_register" value="save-close-info">{{trans('file.submit')}}</button>
	                			  </div>
						        </div>
					      	</div> 
	                    </div>
	                    @endif
                    </form>
            	</div>
        	</div>
    	</div>
    </div>
</section>


@endsection