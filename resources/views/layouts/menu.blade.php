@if ( auth()->user()->role  == 'Admin')
	@include('layouts.menu.admin')
@else
	
@endif