@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.dashboard')
<main class="col bg-faded py-3 flex-grow-1">
    <h3>Data In</h3>
    <br>
	<br>
	<br>
	<div class="signup-form">
		<form action="{{ route('rm/datainsave') }}" method="post" class="form-horizontal">
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
				<input type="date" class="form-control input-sm" id="todate" name="todate" required>
				@error('todate')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>
                           
			<div class="form-group row">
				<label class="col-form-label col-4">Supplier</label>
				<div class="col-8">
				<select class="form-control @error('supplier') is-invalid @enderror" name="supplier">
              		<option value="">Select Supplier</option>
    					@foreach ($data1 as $value)
             			<option value="{{ $value->id }}" {{ (old('supplier') == $value->id ? "selected":"") }}>
                		{{ $value->name }}
              			</option>
     					@endforeach
    			</select>
				@error('supplier')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
				</div>      	
			</div>

			

			<div class="form-group row">
				<label class="col-form-label col-4">Grade</label>
				<div class="col-8">
				<select class="form-control @error('grade') is-invalid @enderror" name="grade">
              		<option value="">Select Grade</option>
    					@foreach ($data2 as $value)
             			<option value="{{ $value->id }}" {{ (old('grade') == $value->id ? "selected":"") }}>
                		{{ $value->name }}
              			</option>
     					@endforeach
    			</select>
					@error('grade')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>

			
			<div class="form-group row">
				<label class="col-form-label col-4">Size</label>
				<div class="col-8">
					<input type="text" class="form-control @error('sizemm') is-invalid @enderror" name="sizemm" value="{{ old('sizemm') }}" placeholder="Enter Size">
					@error('sizemm')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>
			
			<div class="form-group row">
				<label class="col-form-label col-4">QTY(kgs)</label>
				<div class="col-8">
					<input type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" value="{{ old('qty') }}" placeholder="Enter QTY">
					@error('qty')
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