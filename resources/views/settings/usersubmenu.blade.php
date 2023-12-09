@extends('layouts.master')
@include('navbar.header')
@section('content')
@include('sidebar.setting')
<main class="col bg-faded py-3 flex-grow-1">
    <h3>Add User</h3>
    <br>
	<br>
	<br>
	<div class="signup-form">
		<form action="{{ route('form/usersave') }}" method="post" class="form-horizontal">
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
				<label class="col-form-label col-4">First Name</label>
				<div class="col-8">
					<input type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') }}" placeholder="Enter First Name">
					@error('firstName')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>
            <div class="form-group row">
				<label class="col-form-label col-4">Last Name</label>
				<div class="col-8">
					<input type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') }}" placeholder="Enter Last Name">
					@error('lastName')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>
			<div class="form-group row">
				<label class="col-form-label col-4">Role</label>
				<div class="col-8">
				<select class="form-control @error('role') is-invalid @enderror" name="role">
              		<option value="">Select Role</option>
    					@foreach ($data1 as $value)
             			<option value="{{ $value->id }}" {{ (old('role') == $value->id ? "selected":"") }}>
                		{{ $value->name }}
              			</option>
     					@endforeach
    			</select>
				@error('role')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>      	
			</div>
            <div class="form-group row">
				<label class="col-form-label col-4">Email</label>
				<div class="col-8">
					<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email">
					@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>        	
			</div>
			<div class="form-group row">
				<label class="col-form-label col-4">Password</label>
				<div class="col-8">
					<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Enter Password">
					@error('password')
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
						<th style="width:10%">Id</th>					
						<th style="width:10%">First Name</th>
						<th style="width:10%">Last Name</th>
						<th style="width:10%">Role</th>		
                        <th style="width:10%">Email</th>							
						<th style="width:10%">Delete</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $value)
					<tr>
						<td class="id">{{ $value->id }}</td>
						<td class="fname">{{ $value->first_name }}</td>
                        <td class="lname">{{ $value->last_name }}</td>
						<td class="role">{{ $value->role }}</td>
						<td class="mail">{{ $value->email }}</td>
						<td class=" text-left">
							<a href="{{ url('form/deleteUsers'.$value->id) }}" onclick="return confirm('Are you sure to want to delete it?')">
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