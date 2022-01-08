<!DOCTYPE html>
<html>

<head>
	<style>
		/* Styles go here */

		.page-header,
		.page-header-space {
			height: 230px;
		}

		.page-footer,
		.page-footer-space {
			height: 240px;

		}

		.page-footer {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
		}

		.page-header {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
		}
		
		.page {
			page-break-after: always;
		}
		
		.page-alternate {
			/* width: 720px; */
			width: 100%;
			/*height:100vh;*/
		}

       

		@page {
			margin: 20px 30px;
		}

		table.table-bordered {
			border: 1px solid black !important;
		}

		table.table-bordered>thead>tr>th {
			border: 1px solid !important;
		}

		table.table-bordered>tbody>tr>td {
			border: 1px solid !important;
		}
		
	



		@media print {
			thead {
				display: table-header-group;
			}

			tfoot {
				display: table-footer-group;
			}

			/*button {display: none;}

            body {margin: 0;}*/
		}
	</style>
</head>

<body>
    
<?php 
function numberTowords($num)
{

    $ones = array(
        0 =>"ZERO",
        1 => "ONE",
        2 => "TWO",
        3 => "THREE",
        4 => "FOUR",
        5 => "FIVE",
        6 => "SIX",
        7 => "SEVEN",
        8 => "EIGHT",
        9 => "NINE",
        10 => "TEN",
        11 => "ELEVEN",
        12 => "TWELVE",
        13 => "THIRTEEN",
        14 => "FOURTEEN",
        15 => "FIFTEEN",
        16 => "SIXTEEN",
        17 => "SEVENTEEN",
        18 => "EIGHTEEN",
        19 => "NINETEEN"
    );

    $tens = array( 
        0 => "ZERO",
        1 => "TEN",
        2 => "TWENTY",
        3 => "THIRTY", 
        4 => "FORTY", 
        5 => "FIFTY", 
        6 => "SIXTY", 
        7 => "SEVENTY", 
        8 => "EIGHTY", 
        9 => "NINETY" 
    ); 

    $hundreds = array( 
        "HUNDRED", 
        "THOUSAND", 
        "MILLION", 
        "BILLION", 
        "TRILLION", 
        "QUARDRILLION" 
    ); /*limit t quadrillion */

    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    $decnum = $num_arr[1]; 

    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr,1); 

    $rettxt = ""; 
    foreach($whole_arr as $key => $i){
      
        while(substr($i,0,1)=="0")
            $i=substr($i,1,5);
        if($i < 20){ 
            /* echo "getting:".$i; */
            $rettxt .= $ones[$i]; 
        }elseif($i < 100){ 
            if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
            if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
        } else{ 
             if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
            if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
        } 
        if($key > 0){ 
            $rettxt .= " ".$hundreds[$key]." "; 
        }
    } 
    if($decnum > 0){
        $rettxt .= " AND ";
        if($decnum < 20) {
            $rettxt .= $ones[$decnum]." FILS";
        } elseif($decnum < 100) {
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)]. " FILS";
        }
    }
    return $rettxt;
}

?>

	<div class="page-header" style="text-align: center">
		@if(!empty($receipt_details->logo))
		<img style="max-height: 80px; width: auto;" src="{{$receipt_details->logo}}" class="img img-responsive center-block">
		@endif

		@if(!empty($receipt_details->header_text))
		<div class="col-xs-12">
			{!! $receipt_details->header_text !!}
		</div>
		@endif
		
		<div class="col-12">
		    <!-- Title of receipt -->
			@if(!empty($receipt_details->invoice_heading))
			<h3 class="text-center" style="margin-top: 0; margin-bottom:5px;">
				{!! $receipt_details->invoice_heading !!}
				<br>
				فاتورة
			</h3>
			<h5 style="margin-bottom: 0; margin-top:2px;">
				<b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}}
			</h5>
			@endif
		</div>
	

		<div class="col-xs-6">
			<!-- Invoice  number, Date  -->
			<div style="width: 100% !important; font-size: 14px;" class="word-wrap text-left">
				<span class="" style="margin-bottom:0px;">
					@if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}</b>
					@endif
					{{$receipt_details->invoice_no}}

					{{-- @if(!empty($receipt_details->types_of_service))
					<br />
					<span class="pull-left text-left">
						<strong>{!! $receipt_details->types_of_service_label !!}:</strong>
						{{$receipt_details->types_of_service}}
						<!-- Waiter info -->
						@if(!empty($receipt_details->types_of_service_custom_fields))
						@foreach($receipt_details->types_of_service_custom_fields as $key => $value)
						<br><strong>{{$key}}: </strong> {{$value}}
						@endforeach
						@endif
					</span>
					@endif --}}

					<!-- Table information-->
					{{-- @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
					<br />
					<span class="pull-left text-left" style="font-size: 14px;">
						@if(!empty($receipt_details->table_label))
						<b>{!! $receipt_details->table_label !!}</b>
						@endif
						{{$receipt_details->table}}

						<!-- Waiter info -->
					</span>
					@endif --}}

					<!-- customer info -->
					@if(!empty($receipt_details->customer_info))
					<b style="margin-bottom:0px; margin-right:10px;">{!! $receipt_details->customer_info !!}</b> 
					@endif
					@if(!empty($receipt_details->client_id_label))
					<br />
					<b>{{ $receipt_details->client_id_label }}</b> {{ $receipt_details->client_id }}
					@endif
					@if(!empty($receipt_details->customer_tax_label))
					<br />
					<b style="margin-top:0px !important!;">{{ $receipt_details->customer_tax_label }}</b> {{ $receipt_details->customer_tax_number }}
					@endif
					{{-- @if(!empty($receipt_details->customer_custom_fields))
					<br />{!! $receipt_details->customer_custom_fields !!}
					@endif
					@if(!empty($receipt_details->sales_person_label))
					<br />
					<b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }}
					@endif
					@if(!empty($receipt_details->customer_rp_label))
					<br />
					<strong>{{ $receipt_details->customer_rp_label }}</strong> {{ $receipt_details->customer_total_rp }}
					@endif --}}
				</span>

				{{-- <span class="pull-right text-left" style="font-size: 14px;"> --}}
					{{-- <b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}} --}}

					{{-- @if(!empty($receipt_details->due_date_label))
					<br><b>{{$receipt_details->due_date_label}}</b> {{$receipt_details->due_date ?? ''}}
					@endif

					@if(!empty($receipt_details->brand_label) || !empty($receipt_details->repair_brand))
					<br>
					@if(!empty($receipt_details->brand_label))
					<b>{!! $receipt_details->brand_label !!}</b>
					@endif
					{{$receipt_details->repair_brand}}
					@endif --}}


					{{-- @if(!empty($receipt_details->device_label) || !empty($receipt_details->repair_device))
					<br>
					@if(!empty($receipt_details->device_label))
					<b>{!! $receipt_details->device_label !!}</b>
					@endif
					{{$receipt_details->repair_device}}
					@endif --}}

					{{-- @if(!empty($receipt_details->model_no_label) || !empty($receipt_details->repair_model_no))
					<br>
					@if(!empty($receipt_details->model_no_label))
					<b>{!! $receipt_details->model_no_label !!}</b>
					@endif
					{{$receipt_details->repair_model_no}}
					@endif --}}

					{{-- @if(!empty($receipt_details->serial_no_label) || !empty($receipt_details->repair_serial_no))
					<br>
					@if(!empty($receipt_details->serial_no_label))
					<b>{!! $receipt_details->serial_no_label !!}</b>
					@endif
					{{$receipt_details->repair_serial_no}}<br>
					@endif --}}
					{{-- @if(!empty($receipt_details->repair_status_label) || !empty($receipt_details->repair_status))
					@if(!empty($receipt_details->repair_status_label))
					<b>{!! $receipt_details->repair_status_label !!}</b>
					@endif
					{{$receipt_details->repair_status}}<br>
					@endif --}}

					{{-- @if(!empty($receipt_details->repair_warranty_label) || !empty($receipt_details->repair_warranty))
					@if(!empty($receipt_details->repair_warranty_label))
					<b>{!! $receipt_details->repair_warranty_label !!}</b>
					@endif
					{{$receipt_details->repair_warranty}}
					<br>
					@endif --}}

					<!-- Waiter info -->
					{{-- @if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
					<br />
					@if(!empty($receipt_details->service_staff_label))
					<b>{!! $receipt_details->service_staff_label !!}</b>
					@endif
					{{$receipt_details->service_staff}}
					@endif
					@if(!empty($receipt_details->shipping_custom_field_1_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_1_label!!} :</strong> {!!$receipt_details->shipping_custom_field_1_value ?? ''!!}
					@endif --}}

					{{-- @if(!empty($receipt_details->shipping_custom_field_2_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_2_label!!}:</strong> {!!$receipt_details->shipping_custom_field_2_value ?? ''!!}
					@endif

					@if(!empty($receipt_details->shipping_custom_field_3_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_3_label!!}:</strong> {!!$receipt_details->shipping_custom_field_3_value ?? ''!!}
					@endif

					@if(!empty($receipt_details->shipping_custom_field_4_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_4_label!!}:</strong> {!!$receipt_details->shipping_custom_field_4_value ?? ''!!}
					@endif

					@if(!empty($receipt_details->shipping_custom_field_5_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_2_label!!}:</strong> {!!$receipt_details->shipping_custom_field_5_value ?? ''!!}
					@endif --}}
					{{-- sale order --}}
					{{-- @if(!empty($receipt_details->sale_orders_invoice_no))
					<br>
					<strong>@lang('restaurant.order_no'):</strong> {!!$receipt_details->sale_orders_invoice_no ?? ''!!}
					@endif

					@if(!empty($receipt_details->sale_orders_invoice_date))
					<br>
					<strong>@lang('lang_v1.order_dates'):</strong> {!!$receipt_details->sale_orders_invoice_date ?? ''!!}
					@endif --}}
				{{-- </span> --}}
			</div>
		</div>
		
		<div class="col-xs-6">
			<div style="width: 100% !important; font-size: 14px;" class="word-wrap text-right">
				<span class="" style="margin-bottom:0px;">
					@if(!empty($receipt_details->invoice_no_prefix))
					<b>رقم الفاتورة</b>
					@endif
					{{$receipt_details->invoice_no}}

					{{-- @if(!empty($receipt_details->types_of_service))
					<br />
					<span class="pull-left text-left">
						<strong>{!! $receipt_details->types_of_service_label !!}:</strong>
						{{$receipt_details->types_of_service}}
						<!-- Waiter info -->
						@if(!empty($receipt_details->types_of_service_custom_fields))
						@foreach($receipt_details->types_of_service_custom_fields as $key => $value)
						<br><strong>{{$key}}: </strong> {{$value}}
						@endforeach
						@endif
					</span>
					@endif --}}

					<!-- Table information-->
					{{-- @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
					<br />
					<span class="pull-left text-left" style="font-size: 14px;">
						@if(!empty($receipt_details->table_label))
						<b>{!! $receipt_details->table_label !!}</b>
						@endif
						{{$receipt_details->table}}

						<!-- Waiter info -->
					</span>
					@endif --}}

					<!-- customer info -->
					@if(!empty($receipt_details->customer_info))
					{{-- <b style="margin-bottom:0px; ">{!! $receipt_details->customer_info !!}</b>  --}}
					<b>عميل بدون حجز</b><br>
					<b>التليفون المحمول : </b><br>
					@if(!empty($receipt_details->customer_tax_label))
					<b>ضريبة<b> : {{ $receipt_details->customer_tax_number }}
					@endif
					
					@endif
					{{-- @if(!empty($receipt_details->client_id_label))
					<br />
					<b>{{ $receipt_details->client_id_label }}</b> {{ $receipt_details->client_id }}
					@endif --}}
					{{-- @if(!empty($receipt_details->customer_tax_label))
					<br />
					<b style="margin-top:0px !important!;">{{ $receipt_details->customer_tax_label }}</b> {{ $receipt_details->customer_tax_number }}
					@endif --}}
					{{-- @if(!empty($receipt_details->customer_custom_fields))
					<br />{!! $receipt_details->customer_custom_fields !!}
					@endif
					@if(!empty($receipt_details->sales_person_label))
					<br />
					<b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }}
					@endif
					@if(!empty($receipt_details->customer_rp_label))
					<br />
					<strong>{{ $receipt_details->customer_rp_label }}</strong> {{ $receipt_details->customer_total_rp }}
					@endif --}}
				</span>

				{{-- <span class="pull-right text-left" style="font-size: 14px;"> --}}
					{{-- <b>{{$receipt_details->date_label}}</b> {{$receipt_details->invoice_date}} --}}




				
				{{-- </span> --}}
			</div>
			<!-- Address -->
			{{-- <p style="font-size: 16px;border-bottom: 1px solid #d6d6d6"> --}}
				{{-- @if(!empty($receipt_details->address)) --}}
				{{-- <small class="text-center">--}}
				{{-- {!! $receipt_details->address !!} --}}
				{{-- </small>--}}
				{{-- @endif --}}
				{{-- @if(!empty($receipt_details->contact))
				<br />{!! $receipt_details->contact !!}
				@endif
				@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
				,
				@endif
				@if(!empty($receipt_details->website))
				{{ $receipt_details->website }}
				@endif
				@if(!empty($receipt_details->location_custom_fields))
				<br>{{ $receipt_details->location_custom_fields }}
				@endif
			</p>
			<p>
				@if(!empty($receipt_details->sub_heading_line1))
				{{ $receipt_details->sub_heading_line1 }}
				@endif
				@if(!empty($receipt_details->sub_heading_line2))
				<br>{{ $receipt_details->sub_heading_line2 }}
				@endif
				@if(!empty($receipt_details->sub_heading_line3))
				<br>{{ $receipt_details->sub_heading_line3 }}
				@endif
				@if(!empty($receipt_details->sub_heading_line4))
				<br>{{ $receipt_details->sub_heading_line4 }}
				@endif
				@if(!empty($receipt_details->sub_heading_line5))
				<br>{{ $receipt_details->sub_heading_line5 }}
				@endif
			</p>
			<p>
				@if(!empty($receipt_details->tax_info1))
				<b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
				@endif

				@if(!empty($receipt_details->tax_info2))
				<b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
				@endif
			</p> --}}
		</div>

		
	</div>

	


	<div class="page-footer">
		<div class="row" style="margin-top: 35px;margin-bottom: 0">
			<div class="col-md-12">
				<div style="width: 50%;float: left">
					<span style="border-top: 1px solid black">Receiver Signature</span>
				</div>

				<div style="width: 50%;float: right;text-align: right">
					<span style="border-top: 1px solid black">Sales Man Signature</span>
				</div>
			</div>
		</div>





		@if(!empty($receipt_details->footer_text))
		<div class="row">


			@if(!empty($receipt_details->show_barcode))
			<div class="col-xs-3">
				<br>
				<br>
				{{-- Barcode --}}
				<img class="center-block mt-5" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
			</div>
			@endif

			<div class="@if($receipt_details->show_barcode || $receipt_details->show_qr_code) col-xs-6 @else col-xs-12 @endif">
				{!! $receipt_details->footer_text !!}
			</div>

			@if(!empty($receipt_details->show_qr_code))
			<div class="col-xs-3 float-right">
				{{-- QRCode --}}
				<img class="center-block mt-5" src="data:image/png;base64,{{DNS2D::getBarcodePNG($receipt_details->qr_code_text, 'QRCODE', 3, 3, [39, 48, 54])}}">
			</div>
			@endif

            
			
			<!--<img style="max-height: 75px; width: auto;" src="{{asset('footer_banner3.png')}}" class="img img-responsive center-block">-->
			@if(!empty($receipt_details->footer_logo))
    			@if($receipt_details->show_footer_logo == 1)
        		<img style="max-height: 75px; width: auto;" src="{{$receipt_details->footer_logo}}" class="img img-responsive center-block">
        		@endif
    		@endif

		</div>
		@endif



		
				
		
	</div>

	<table>

		<thead>
			<tr>
				<td>
					<!--place holder for the fixed-position header-->
					<div class="page-header-space">
					   
					</div>
				</td>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>
					<!--*** CONTENT GOES HERE ***-->
					<div class="page">
						@php
						$p_width = 40;
						@endphp
						@if(!empty($receipt_details->item_discount_label))
						@php
						$p_width -= 25;
						@endphp
						@endif
						<table class="table table-bordered table-responsive" style="border-color: black !important;" id="content">
							<thead>
								<tr class="bg-primary text-white">
									<th width="8%" class="text-center">SL NO.<br>الرقم التسلسلي</th>
									<!--<th width="{{$p_width}}%" style="padding-left: 5px">{{$receipt_details->table_product_label}}</th>-->
									<th width="{{$p_width}}%" style="padding-left: 5px">Product Description (وصف المنتج)</th>
									<!--<th class="text-right" style="padding-right: 5px" width="10%">{{$receipt_details->table_qty_label}}</th>-->
									<th class="text-right" style="padding-right: 5px" width="10%">Quantity<br> (الكمية)</th>
									<th class="text-right" style="padding-right: 5px" width="10%">Price (السعر)</th>
									@if(!empty($receipt_details->item_discount_label))
									<th class="text-right" width="15%">{{$receipt_details->item_discount_label}}</th>
									@endif
									<!--<th class="text-right" style="padding-right: 5px" width="10%">{{$receipt_details->table_subtotal_label}}</th>-->
								    <th class="text-right" style="padding-right: 5px" width="10%">Taxable Amount <br> (المبلغ الخاضع للضريبة)</th>
								    <th class="text-right" style="padding-right: 5px" width="10%">Tax <br> (ضريبة)</th>
								    <th class="text-right" style="padding-right: 5px" width="10%">Tax Amount<br> (قيمة الضريبة)</th>
								    <th class="text-right" style="padding-right: 5px" width="10%">Total Amount<br> (المبلغ الإجمالي)</th>
								</tr>
							</thead>
							<tbody>
								
								<?php 
								    $i = 1;
								    $total_amount = 0;
								    $total_taxable_amount = 0;
								    $total_tax_amount = 0;
								?>
							
								
								@forelse($receipt_details->lines as $line)
							     <tr style="border:0 !important; min-height:100px;">
									<td class="text-center">{{ $i++ }}</td>
									<td style="padding-left: 5px">
										@if(!empty($line['image']))
										<img src="{{$line['image']}}" alt="Image" width="50" style="float: left; margin-right: 8px;">
										@endif
										{{$line['name']}} {{$line['product_variation']}} {{$line['variation']}}
										@if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif @if(!empty($line['cat_code']))
										, {{$line['cat_code']}}@endif
										@if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
										@if(!empty($line['sell_line_note']))
										<br>
										<small>
											{{$line['sell_line_note']}}
										</small>
										@endif
										@if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}: {{$line['lot_number']}} @endif
										@if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}: {{$line['product_expiry']}} @endif

										@if(!empty($line['warranty_name'])) <br><small>{{$line['warranty_name']}} </small>@endif @if(!empty($line['warranty_exp_date']))
										<small>- {{@format_date($line['warranty_exp_date'])}} </small>@endif
										@if(!empty($line['warranty_description'])) <small> {{$line['warranty_description'] ?? ''}}</small>@endif
									</td>
									<td class="text-right" style="padding-right: 5px">{{$line['quantity']}} {{$line['units']}} </td>
									<td class="text-right" style="padding-right: 5px">{{$line['unit_price_before_discount']}}</td>
									@if(!empty($receipt_details->item_discount_label))
									<td class="text-right">
										{{$line['line_discount'] ?? '0.00'}}
									</td>
									@endif
									<!--<td class="text-right" style="padding-right: 5px">{{$line['line_total']}}</td>-->
									<td class="text-right" style="padding-right: 5px">
									    {{$line['line_total']}}
									    <?php $total_taxable_amount += $line['line_total']; ?>
									    </td>
									<td>
									    {{ $receipt_details->tax_amount }}
									    <!--{{ (int)$receipt_details->tax }}-->
									</td>
									<td>
									    <?php 
									    $tax_amount = $line['line_total']*$receipt_details->tax_amount/100;
									    ?>
									    {{ $tax_amount }}
									    <?php $total_tax_amount += $tax_amount  ?>
									</td>
									<td>
									    <?php $subtotal = $tax_amount+$line['line_total']; ?>
									    {{ $subtotal }}
									    <?php $total_amount += $subtotal; ?>
									</td>
								</tr>
								@if(!empty($line['modifiers']))
								@foreach($line['modifiers'] as $modifier)
								<tr>
									<td>
										{{$modifier['name']}} {{$modifier['variation']}}
										@if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
										@if(!empty($modifier['sell_line_note']))({{$modifier['sell_line_note']}}) @endif
									</td>
									<td class="text-right">{{$modifier['quantity']}} {{$modifier['units']}} </td>
									<td class="text-right">{{$modifier['unit_price_inc_tax']}}</td>
									@if(!empty($receipt_details->item_discount_label))
									<td class="text-right">0.00</td>
									@endif
									<td class="text-right">{{$modifier['line_total']}}</td>
								</tr>
								@endforeach
								
								@endif
								@empty
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
							
								
								@endforelse
								<?php $j = 11; ?>
								@for($k=$i; $k <= $j; $k++)
								<tr>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-right:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-left:0 !important;"></td>
								    <td style="border-left:1px solid black !important; border-bottom:0 !important; border-top:0 !important;border-right:0 !important;"></td>
								</tr>
								@endfor
					
								
								<?php 
								
								$western_arabic = array('0','1','2','3','4','5','6','7','8','9');
                                $eastern_arabic = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
                                
								?>
								
								
								<tr>
								    <td colspan="8" rowspan="2">
								        <strong>Amount IN Words : </strong><span>{{ numberTowords((double)$total_amount) }}</span>
								    </td>
								</tr>
							</tbody>
						</table>
						
						
					
						<div class="row">
							<div class="col-xs-6">
							    <table class="table table-slim" border="1">
							     <tr>
								    <td  style="text-align:right;font-weight:bold; border-top:1px solid black;">{!! $receipt_details->subtotal_label !!}</td>
								    <td  style="text-align:right; font-weight:bold; border-top:1px solid black;">{{ $total_taxable_amount }}</td>
								</tr>
								
								<tr>
								    <td  style="text-align:right;font-weight:bold; border-top:1px solid black;">Tax ({{ $receipt_details->tax_amount }} Percent Vat):</td>
								    <td  style="text-align:right; font-weight:bold; border-top:1px solid black;">{{ $total_tax_amount }}</td>
								
								</tr>
								
									<tr>
								    <td  style="text-align:right;font-weight:bold; border-top:1px solid black;">{!! $receipt_details->total_label !!} </td>
								    <td  style="text-align:right; font-weight:bold; border-top:1px solid black;">{{ $total_amount }} </td>
								    
								</tr>
								
							    </table>
								<!--<table class="table table-slim">-->

								<!--	@if(!empty($receipt_details->payments))-->
								<!--	@foreach($receipt_details->payments as $payment)-->
								<!--	<tr>-->
								<!--		<td>{{$payment['method']}}</td>-->
								<!--		<td class="text-right">{{$payment['amount']}}</td>-->
								<!--		<td class="text-right">{{$payment['date']}}</td>-->
								<!--	</tr>-->
								<!--	@endforeach-->
								<!--	@endif-->

									<!-- Total Paid-->
								<!--	@if(!empty($receipt_details->total_paid))-->
								<!--	<tr>-->
								<!--		<th>-->
								<!--			{!! $receipt_details->total_paid_label !!}-->
								<!--		</th>-->
								<!--		<td class="text-right">-->
								<!--			{{$receipt_details->total_paid}}-->
								<!--		</td>-->
								<!--	</tr>-->
								<!--	@endif-->

									<!-- Total Due-->
								<!--	@if(!empty($receipt_details->total_due))-->
								<!--	<tr>-->
								<!--		<th>-->
								<!--			{!! $receipt_details->total_due_label !!}-->
								<!--		</th>-->
								<!--		<td class="text-right">-->
								<!--			{{$receipt_details->total_due}}-->
								<!--		</td>-->
								<!--	</tr>-->
								<!--	@endif-->

								<!--	@if(!empty($receipt_details->all_due))-->
								<!--	<tr>-->
								<!--		<th>-->
								<!--			{!! $receipt_details->all_bal_label !!}-->
								<!--		</th>-->
								<!--		<td class="text-right">-->
								<!--			{{$receipt_details->all_due}}-->
								<!--		</td>-->
								<!--	</tr>-->
								<!--	@endif-->
								<!--</table>-->
							</div>

							<div class="col-xs-6">
							    <table class="table table-slim" border="1">
							        <tr>
								    <td  style="text-align:right;font-weight:bold; border-top:1px solid black;"> المجموع الفرعي</td>

								    
								    <td style="font-weight:bold;text-align:right; border-top:1px solid black;">
								        {{ str_replace($western_arabic, $eastern_arabic, $total_taxable_amount) }}
								    </td>
								</tr>
								
								<tr>
								    <td style="text-align:right;font-weight:bold; border-top:1px solid black;">الضريبة (15 بال{{ $receipt_details->tax_amount  }}ئة ضريبة القيمة المضافة):</td>
								  
								    
								    <td  style="font-weight:bold;text-align:right; border-top:1px solid black;">
								        {{ str_replace($western_arabic, $eastern_arabic, $total_tax_amount) }}
								    </td>
								</tr>
								
								<tr>
								    <td style="text-align:right;font-weight:bold; border-top:1px solid black;"> مجموع</td>
							
								    
								    <td style="font-weight:bold;text-align:right; border-top:1px solid black;">
								        {{ str_replace($western_arabic, $eastern_arabic, $total_amount) }}
								    </td>
								</tr>
							    </table>
								<!--<div class="table-responsive">-->
									<!--<table class="table table-slim">-->
									<!--	<tbody>-->
											<!--@if(!empty($receipt_details->total_quantity_label))-->
											<!--<tr class="color-555">-->
											<!--	<th style="width:70%">-->
											<!--		{!! $receipt_details->total_quantity_label !!}-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
											<!--		{{$receipt_details->total_quantity}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->
											<!--<tr>-->
											<!--	<th style="width:70%">-->
											<!--		{!! $receipt_details->subtotal_label !!}-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
													<!--{{$receipt_details->subtotal}}-->
													<!--{{ $total_amount }}-->
											<!--		{{ $total_taxable_amount }}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@if(!empty($receipt_details->total_exempt_uf))-->
											<!--<tr>-->
											<!--	<th style="width:70%">-->
											<!--		@lang('lang_v1.exempt')-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
											<!--		{{$receipt_details->total_exempt}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->
											<!-- Shipping Charges -->
											<!--@if(!empty($receipt_details->shipping_charges))-->
											<!--<tr>-->
											<!--	<th style="width:70%">-->
											<!--		{!! $receipt_details->shipping_charges_label !!}-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
											<!--		{{$receipt_details->shipping_charges}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->

											<!--@if(!empty($receipt_details->packing_charge))-->
											<!--<tr>-->
											<!--	<th style="width:70%">-->
											<!--		{!! $receipt_details->packing_charge_label !!}-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
											<!--		{{$receipt_details->packing_charge}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->

											<!-- Discount -->
											<!--@if( !empty($receipt_details->discount) )-->
											<!--<tr>-->
											<!--	<th>-->
											<!--		{!! $receipt_details->discount_label !!}-->
											<!--	</th>-->

											<!--	<td class="text-right">-->
											<!--		(-) {{$receipt_details->discount}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->

											<!--@if( !empty($receipt_details->reward_point_label) )-->
											<!--<tr>-->
											<!--	<th>-->
											<!--		{!! $receipt_details->reward_point_label !!}-->
											<!--	</th>-->

											<!--	<td class="text-right">-->
											<!--		(-) {{$receipt_details->reward_point_amount}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->

											<!-- Tax -->
											<!--@if( !empty($receipt_details->tax) )-->
											<!--<tr>-->
											<!--	<th>-->
											<!--		{!! $receipt_details->tax_label !!}-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
													<!--(+) {{$receipt_details->tax}}-->
													<!--<?php $tax_total = $total_amount*$receipt_details->tax_amount/100 ?>-->
											<!--		{{ $total_tax_amount }}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->

											<!--@if( $receipt_details->round_off_amount > 0)-->
											<!--<tr>-->
											<!--	<th>-->
											<!--		{!! $receipt_details->round_off_label !!}-->
											<!--	</th>-->
											<!--	<td class="text-right">-->
											<!--		{{$receipt_details->round_off}}-->
											<!--	</td>-->
											<!--</tr>-->
											<!--@endif-->

											<!-- Total -->
											<!--<tr>-->
											<!--	<th>-->
											<!--		{!! $receipt_details->total_label !!}-->
													
											<!--	</th>-->
											<!--	<td class="text-right" style="border: 1px solid black">-->
													<!--{{$receipt_details->total}}-->
											<!--		{{ $total_amount }} -->
											<!--		@if(!empty($receipt_details->total_in_words))-->
											<!--		<br>-->
											<!--		<small>({{$receipt_details->total_in_words}})</small>-->
											<!--		@endif-->
											<!--	</td>-->
											<!--</tr>-->
									<!--	</tbody>-->
									<!--</table>-->
								<!--</div>-->
							</div>
							<div class="col-xs-12">
								<p>{!! nl2br($receipt_details->additional_notes) !!}</p>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</tbody>

		<tfoot>
			<tr>
				<td>
					<!--place holder for the fixed-position footer-->
					<div class="page-footer-space"></div>
				
				</td>
			</tr>
		</tfoot>

	</table>
	

</body>

</html>