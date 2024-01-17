@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.rm')
<main class="col bg-faded py-3 flex-grow-1">
    <h3>Data Out</h3>
    <br>
	<br>
	<br>
	<div class="signup-form">
		<form action="{{ route('rm/dataoutsave') }}" method="post" class="form-horizontal">
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
					<input type="text" class="form-control @error('size') is-invalid @enderror" name="size" value="{{ old('size') }}" placeholder="Enter Size">
					@error('size')
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
				<label class="col-form-label col-4">Product</label>
				<div class="col-8">
				<select class="form-control @error('product') is-invalid @enderror" name="product">
              		<option value="">Select Product</option>
    					@foreach ($data3 as $value)
             			<option value="{{ $value->id }}" {{ (old('product') == $value->id ? "selected":"") }} >
                		{{ $value->name }}
              			</option>
     					@endforeach
    			</select>
					@error('product')
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

	<div class="container-fluid">
			<table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
				<thead>
					
					<tr>
						<th>ID</th>										
						
						<th>grade</th>
						<th>size</th>
						<th>quantity</th>
						<th>Product</th>

					</tr>
				</thead>
				<tbody>
					@foreach($data4 as $value)
					<tr>
						<td class="id">{{ $value->id }}</td>
						
						<td class="grade">{{ $value->gradeid }}</td>
						<td class="size">{{ $value->size }}</td>
						<td class="quantity">{{ $value->quantity }}</td>
						<td class="product">{{ $value->productid }}</td>

						
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	{{-- </table> --}}	
	
	<!-- Modal Update-->
	<div class="modal fade" id="update" tabindex="-1" aria-labelledby="update" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="update">Update</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="update" action="{{ route('form/update') }}" method = "post"><!-- form add -->
					{{ csrf_field() }}
					<div class="modal-body">
						<input type="hidden" class="form-control" id="e_id" name="id" value=""/>
						<div class="modal-body">
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Operator</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="e_name" name="name" required="" value=""/>
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Duration</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="e_timerange" name="timerange" required="" value=""/>
								</div>
							</div>
							<div class="form-group row">
								<label for="" class="col-sm-3 col-form-label">Count</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="e_prdcount" name="prdcount" required="" value=""/>
								</div>
							</div>
						</div>
						<!-- form add end -->
					</div>
					<div class="modal-footer">
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="icofont icofont-eye-alt"></i>Close</button>
							<button type="submit" id=""name="" class="btn btn-success  waves-light"><i class="icofont icofont-check-circled"></i>Update</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Modal Update-->

	{{-- script update --}}
	
	<script>
		$(document).on('click','.update',function()
		{
			var _this = $(this).parents('tr');
			$('#e_id').val(_this.find('.id').text());
			$('#e_name').val(_this.find('.product').text());
			$('#e_email').val(_this.find('.size').text());
			$('#e_phone').val(_this.find('.quantity').text());
		});
	</script>
	


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