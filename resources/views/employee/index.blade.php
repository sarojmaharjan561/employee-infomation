@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">   
                        Employee List 
                        <a class="btn btn-primary btn-sm float-right" href="{{ url('/employee/create') }}">Add New</a> 
                    </div>
				    <employee-index></employee-index>
			    </div>
            </div>
        </div>
    </div>
@endsection


