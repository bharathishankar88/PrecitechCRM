@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.form')
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
				<label class="col-form-label col-4">Machine Name</label>
				<div class="col-8">
				<select class="form-control" name="machine">
              		<option>Select Machine</option>
    					@foreach ($data1 as $value)
             			<option value="{{ $value->id }}" >
                		{{ $value->id }}
              			</option>
     					@endforeach
    			</select>
				</div>      	
			</div>

			<div class="form-group row">
				<label class="col-form-label col-4">Operator</label>
				<div class="col-8">
				<select class="form-control" name="operator">
              		<option>Select Operator</option>
    					@foreach ($data1 as $value)
             			<option value="{{ $value->id }}" >
                		{{ $value->name }}
              			</option>
     					@endforeach
    			</select>
				</div>      	
			</div>

			<div class="form-group row">
				<label class="col-form-label col-4">Product</label>
				<div class="col-8">
				<select class="form-control" name="product">
              		<option>Select Product</option>
    					@foreach ($data1 as $value)
             			<option value="{{ $value->id }}" >
                		{{ $value->name }}
              			</option>
     					@endforeach
    			</select>
				</div>      	
			</div>

			<div class="form-group row">
				<label class="col-form-label col-4">Time Range</label>
				<div class="col-8">
					<input type="text" class="form-control @error('timeRange') is-invalid @enderror" name="timeRange" value="{{ old('timeRange') }}" placeholder="Enter Time">
					@error('timeRange')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>
			
			<div class="form-group row">
				<label class="col-form-label col-4">No. Items Produced</label>
				<div class="col-8">
					<input type="tel" class="form-control @error('itemProduced') is-invalid @enderror" name="itemProduced" value="{{ old('itemProduced') }}" placeholder="Enter Items Produced">
					@error('itemProduced')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror  
				</div>      	
			</div>

			

			


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
</main>
@endsection