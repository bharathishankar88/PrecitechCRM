@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.setting')
<main class="col bg-faded py-3 flex-grow-1">
    <h3>Add Machine</h3>
    <br>
	<br>
	<br>
	<div class="signup-form">
		<form action="{{ route('form/machinesave') }}" method="post" class="form-horizontal">
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
					<input type="text" class="form-control @error('machineName') is-invalid @enderror" name="machineName" value="{{ old('machineName') }}" placeholder="Enter Machine Name">
					@error('machineName')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>
			
			<div class="form-group row">
				<label class="col-form-label col-4">Floor Name</label>
				<div class="col-8">
					<input type="tel" class="form-control @error('floorName') is-invalid @enderror" name="floorName" value="{{ old('floorName') }}" placeholder="Enter Floor Name">
					@error('floorName')
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
			
			<div class="container-fluid">
			<table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
				<thead>
					
					<tr>
						<th>Id</th>					
						<th>Machine Name</th>	
						<th>Floor Name</th>						
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $value)
					<tr>
						<td class="id">{{ $value->id }}</td>
						<td class="name">{{ $value->name }}</td>
						<td class="floor">{{ $value->floor }}</td>
						<td class=" text-left">
							<a href="{{ url('form/deleteMachines'.$value->id) }}" onclick="return confirm('Are you sure to want to delete it?')">
								<i class="fa fa-trash" style="color: red;"></i>
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
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