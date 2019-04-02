@extends('layouts.app')
@section('content')
    <h2>Revenue Statistics</h2>
    <div class="container">
        <table>
              <tr>
                <th>Name Airport From</th>
                <th>Name Airport To</th>
              </tr>
       <?php foreach ($air as $item): ?>
   <tr>
  
        <th><?php echo $item->name_a_from ?></th>
        <th><?php echo $item->name_a_to ?></th>
   
 </tr>
   <?php endforeach; ?>
        </table>
    </div>
@endsection