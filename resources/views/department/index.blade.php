@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">   
                        Department List 
                        <a class="btn btn-primary btn-sm float-right" href="{{ url('/department/create') }}">Add New</a> 
                    </div>
				    <department-index></department-index>
				</div>
            </div>
        </div>
    </div>
@endsection


