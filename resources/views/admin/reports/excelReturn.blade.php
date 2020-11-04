<!DOCTYPE html>
<html>
<head>
	<title>Income</title>
	<style type="text/css">
.table>tbody>tr>td {
    vertical-align: top;
}
	</style>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th colspan="3" style="border: 2px solid black;" height="23px" align="center">Laporan Total Pengembalian{{$type}}</th>
			</tr>
			<tr>
				<th colspan="3" style="border: 2px solid black;" height="23px" align="center">Periode {{$by}}</th>
			</tr>

		</thead>
		<tbody>
			<?php $total=0; ?>
			  <tr>
			    <th  height="23px" style="border: 2px solid black;">Nama Barang</th>
			    <th  height="23px" style="border: 2px solid black;">Date</th>
			    <th  height="23px" style="border: 2px solid black;">Total Barang Masuk</th>
			  </tr>
			  <?php $total=0; ?>
			  @foreach($data as $key => $value)
			      <?php $sub=0;?>
				  @foreach ($value['data'] as $keyTemp => $valueTemp) 
					  <tr>
					  	@if($sub=="0")
					    	<td style="border: 2px solid black;vertical-align: middle !important;" align="top" height="23px" width="25px" rowspan="{{count($value['data'])}}">{{$value['name']}}</td>
					  	@else
					    	<td style="border: 2px solid black;vertical-align: middle !important;" align="top" height="23px" width="25px"></td>
					  	@endif
					    <td style="border: 2px solid black;" height="23px" width="25px">{{$keyTemp}}</td>
					    <td style="border: 2px solid black;" height="23px" width="25px">{{$valueTemp}}</td>
					  </tr>
					  <?php $sub++; ?>
					  <?php $total+=$valueTemp; ?>
				  @endforeach
			  @endforeach
			<tr>
				<td align="center" height="23px" style="border: 2px solid black;font-weight: bold;" colspan="2">Total</td>
				<td align="center" height="23px" style="border: 2px solid black;font-weight: bold;" colspan="1">{{$total}}</td>
			</tr>
		</tbody>
	</table>
</body>
</html>