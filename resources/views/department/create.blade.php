@extends('layouts.app')

@section('content')
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
					<div class="card-header">   
				        Department Create 
				        <a class="btn btn-primary btn-sm float-right" href="{{ url('/department') }}">Back </a>
				    </div>
    				<department-create :id="{{request()->route('id')?? 0 }}"></department-create>
    			</div>
    		</div>
    		<div class="clear-fix"></div>
    	</div>
    </div>    		
@endsection


