@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')
<main class="col bg-faded py-3 flex-grow-1">


    <h3>Data Entry</h3>
    <br>
	<br>
	<br>
	<div class="signup-form">
		<form action="{{ route('form/page_test/save') }}" method="post" class="form-horizontal">
			{{ csrf_field() }}
			
			{{-- success --}}
			@if(\Session::has('insert'))
				<div id="insert" class=" alert alert-success">
					{!! \Session::get('insert') !!}
				</div>
			@endif

			{{-- error --}}
			@if(\Session::has('error'))
				<div id="error" class=" alert alert-danger">
					{!! \Session::get('error') !!}
				</div>
			@endif
			 

			<div class="form-group row">
			<label class="col-form-label col-4">Data Entry For</label>
				<div class="col-8">
				<input type="date" class="form-control input-sm" id="todate" name="todate" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date("Y-m-d"); ?>" required>
				@error('todate')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>
                           
			<div class="form-group row">
				<label class="col-form-label col-4">Machine Name</label>
				<div class="col-8">
				<input type="text" class="form-control @error('machine') is-invalid @enderror" name="machine" value="{{ old('machine') }}" placeholder="Enter Machine Name" list="machines" autocomplete="off" required>
				<datalist id="machines">
              		<!--<option data-value="">Select Machine</option>-->
    					@foreach ($data1 as $value)
             			<option value="{{ $value->name }}" {{ (old('machine') == $value->id ? "selected":"") }}>
                		
     					@endforeach
				</datalist>
				@error('machine')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>

			

			<div class="form-group row">
				<label class="col-form-label col-4">Operator</label>
				<div class="col-8">
				<input type="text" class="form-control @error('operator') is-invalid @enderror" name="operator" value="{{ old('operator') }}" placeholder="Enter operator Name" list="operators" autocomplete="off" required>
				<datalist id="operators">
              		<!--<option value="">Select Operator</option>-->
    					@foreach ($data2 as $value)
             			<option value="{{ $value->name }}" {{ (old('operator') == $value->id ? "selected":"") }}>
                		
     					@endforeach
				</datalist>
					@error('operator')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>

			<div class="form-group row">
				<label class="col-form-label col-4">Product</label>
				<div class="col-8">
				<input type="text" class="form-control @error('product') is-invalid @enderror" name="product" value="{{ old('product') }}" placeholder="Enter product Name" list="products" autocomplete="off" required>
				<datalist id="products">
              		<!--<option value="">Select Product</option>-->
    					@foreach ($data3 as $value)
             			<option value="{{ $value->name }}" {{ (old('product') == $value->id ? "selected":"") }} >
                		
     					@endforeach
    			</select>
					@error('product')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>

			<!--<div class="form-group row">
				<label class="col-form-label col-4">Time Range</label>
				<div class="col-8">
					<input type="text" class="form-control @error('timeRange') is-invalid @enderror" name="timeRange" value="{{ old('timeRange') }}" placeholder="Enter Time">
					@error('timeRange')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>-->
			
			<div id="box">
			<div class="form-group row">
				<label class="col-form-label col-4">Time Slot</label>
				<div class="col-sm-2">
				<select class="form-control @error('timeslot1') is-invalid @enderror" name="timeslot1[]">
              		<option value="">--start time--</option>
    					@foreach ($data4 as $value)
             			<option value="{{ $value['name'] }}" {{ (old('timeslot1') == $value['name'] ? "selected":"") }} >
                		{{ $value['name'] }}
              			</option>
     					@endforeach
    			</select>
				@error('timeslot1')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
				
				<div class="col-sm-2">

				<select class="form-control @error('timeslot2') is-invalid @enderror" name="timeslot2[]">
              		<option value="">--end time--</option>
    					@foreach ($data4 as $value)
             			<option value="{{ $value['name'] }}" {{ (old('timeslot2') == $value['name'] ? "selected":"") }} >
                		{{ $value['name'] }}
              			</option>
     					@endforeach
    			</select>
					@error('timeslot2')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>


			<div class="form-group row">
				<label class="col-form-label col-4">No. Items Produced</label>
				<div class="col-8">
					<input type="tel" class="form-control @error('itemProduced') is-invalid @enderror" name="itemProduced[]" value="{{ old('itemProduced[]') }}" placeholder="Enter Items Produced" required>
					@error('itemProduced')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>      	
			</div>
</div>
<hr>
<a href="#" id="add"><i class="fa fa-plus" style="color: red;"></i>Add More Input Field</a>

			


			<div class="form-group row">
				<div class="col-8 offset-4">
					<button type="submit" class="btn btn-primary btn-lg">Save</button>
				</div>  
			</div>		      
		</form>
	</div>
    {{-- hide message js --}}
    <script>
        $('#insert').show();
        setTimeout(function()
        {
            $('#insert').hide();
        },5000);

		$('#error').show();
        setTimeout(function()
        {
            $('#error').hide();
        },5000);
        
    </script>    
	<script>
$(document).ready(function(){    
    $('#add').click(function(){    
		var inp = $('#box');        
        var i =  1;        
        $('<div><div class="form-group row"><label class="col-form-label col-4">Time Slot</label>	<div class="col-sm-2">	<select class="form-control @error("timeslot1") is-invalid @enderror" name="timeslot1[]">  <option value="">--start time--</option>	@foreach ($data4 as $value)	<option value="{{ $value["name"] }}" {{ (old("timeslot1") == $value["name"] ? "selected":"") }} >  		{{ $value["name"] }}   			</option>	@endforeach		</select>	@error("timeslot1")			<span class="invalid-feedback" role="alert">		<strong>{{ $message }}</strong>			</span>				@enderror	</div>			<div class="col-sm-2"><select class="form-control @error("timeslot2") is-invalid @enderror" name="timeslot2[]"><option value="">--end time--</option>		@foreach ($data4 as $value)    <option value="{{ $value["name"] }}" {{ (old("timeslot2") == $value["name"] ? "selected":"") }} >{{ $value["name"] }}	</option> @endforeach	</select>	@error("timeslot2")	<span class="invalid-feedback" role="alert">		<strong>{{ $message }}</strong>	</span>	@enderror</div>    </div><div class="form-group row"><label class="col-form-label col-4">No. Items Produced</label><div class="col-8">	<input type="tel" class="form-control" name="itemProduced[]" placeholder="Enter Items Produced" required>  </div>      	</div><i class="fa fa-trash" style="color: red;" id="remove"></i> </div><hr>').appendTo(inp);
        i++;    
		//window.scrollTo(0, 10000);
    });
    
    
    
    $('body').on('click','#remove',function(){        
        $(this).parent('div').remove();
        
    });

        
});

</script>    
</main>
@endsection