@extends('layout.top-head') @section('content')

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Close Register')}}</h4>
                    </div>
                    <form action="{{route('register.close.post', $register->id)}}" method="POST">
                    	@csrf
	                    @if(!$register->register_close_amount)
	                    <div class="card-body">
	                    	<div class="row">
	                    		<div class="container">
	                    			<div class="col-md-6 offset-md-3" style="text-align:center;">
	                    				<h3>{{trans('file.total_on_hand')}}</h3>
	                    				<em>Cash + Credit Card Slips</em>
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
						            <tbody><tr>
						              <td>
						                Begining Amount:
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->open_amount}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                Cash Payment:
						              
						              </td><td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_cash}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                Cheque Payment:
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_cheque}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                Card Payment:
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_card}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                Bank Transfer:
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_bank_transfer}}</span>
						              </td>
						            </tr>
						            <tr>
						              <td>
						                Total Sales:
						              </td>
						              <td>
						                <span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_sale}}</span>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						                Total Refund              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_refund}}</span></b><br>
						                <small>
						                </td>
						            </tr>
						            <tr class="success">
						              <th>
						                Total Cash Sales              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_cash - $register_details->total_cash_refund }}</span></b>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						                Credit Sales:
						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_card - $register_details->total_card_refund }}</span></b>
						              </td>
						            </tr>
						            <tr class="success">
						              <th>
						                Total In Register: (Open + Cash + Credit)
						              </th>
						              <td>
						                <b><span class="display_currency" data-currency_symbol="true">L.E {{$register_details->total_sale + $register_details->open_amount}}</span></b>
						              </td>
						            </tr>
						          </tbody></table>
						        </div>
					      	</div>

					      	<div class="row">
						        <div class="col-sm-3">
						          <div class="form-group">
						            <label for="total_cash">Total Cash:*</label>
						              <input class="form-control input_number" required="" placeholder="Total Cash" name="total_cash" type="text" value="{{$register_details->total_cash - $register_details->total_cash_refund + $register_details->open_amount}}" id="total_cash" disabled>
						          </div>
						        </div>
						        <div class="col-sm-3">
						          <div class="form-group">
						            <label for="total_card_slips">Total Card Slips:*</label> <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Total number of card payments used in this register" data-html="true" data-trigger="hover"></i>              <input class="form-control" required="" placeholder="Total Card Slips" name="total_card_slips" type="text" value="{{$register_details->total_card - $register_details->total_card_refund}}" id="total_card_slips"disabled>
						          </div>
						        </div> 
						        <div class="col-sm-3">
						          <div class="form-group">
						            <label for="total_cheques">Total cheques:*</label> <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Total number of cheques used in this register" data-html="true" data-trigger="hover"></i>              <input class="form-control" required="" placeholder="Total cheques" name="total_cheques" type="text" value="{{$register_details->total_cheque}}" id="total_cheques" disabled>
						          </div>
						        </div> 
						        <div class="col-sm-3">
						          <div class="form-group">
						            <label for="closing_amount">Closing Cash Amount:*</label> <i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" data-container="body" data-toggle="popover" data-placement="auto bottom" data-content="Total number of cheques used in this register" data-html="true" data-trigger="hover"></i>              <input class="form-control" required="" placeholder="Closing Cash Amount" name="closing_amount" type="text" value="{{$register_details->total_cheque}}" id="total_cheques">
						          </div>
						        </div> 
						        <div class="col-sm-12">
						          <div class="form-group">
						            <label for="closing_note">Closing Note:</label>
						              <textarea class="form-control" placeholder="Closing Note" rows="3" name="closing_note" cols="50" id="closing_note"></textarea>
						          </div>
						          <div class="form-group">
	                					<button class="btn btn-primary" type="submit" name="close_register" value="save-close-info">{{trans('file.submit')}}</button>
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