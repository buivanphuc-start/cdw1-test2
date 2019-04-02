@extends('layouts.app')
@section('content')
	
	<div class="container">
		<h2>Revenue Statistics</h2>
		<table>
			  <tr>
			    <th>Airplane</th>
			    <th>Revenue</th> 
			  </tr>
			  @foreach($db as $db)
			  <tr>
			    <td>{{$db->airplane_name}}</td>
			    <td>{{$db->total_cost}}</td>
			  </tr>
			  @endforeach
		</table>
	</div>
@endsection