@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">   
                        Employee Create 
                        <a class="btn btn-primary btn-sm float-right" href="{{ url('/employee') }}">Back </a>
                    </div>
				    <employee-create :id="{{request()->route('id')?? 0 }}"></employee-create>
			    </div>
            </div>
            <div class="clear-fix"></div>           
        </div>
    </div>
@endsection


