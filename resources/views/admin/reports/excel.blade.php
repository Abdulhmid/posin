<!DOCTYPE html>
<html>
<head>
	<title>Income</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th colspan="6" style="border: 2px solid black;" height="23px" align="center">Laporan Pendapatan {{$type}}</th>
			</tr>
			<tr>
				<th colspan="6" style="border: 2px solid black;" height="23px" align="center">Periode {{$by}}</th>
			</tr>
			<tr>
				<th colspan="3" height="23px" style="border: 2px solid black;">Data</th>
				<th colspan="3" height="23px" style="border: 2px solid black;">Income</th>
			</tr>
		</thead>
		<tbody>
			<?php $total=0; ?>
			@foreach($data as $key => $value)
				<tr>
					<td style="border: 2px solid black;" height="23px" colspan="3">{{$value['data']}}</td>
					<td style="border: 2px solid black;" height="23px" colspan="3">{{$value['total']}}</td>
				</tr>
				<?php $total+=$value['total']; ?>
			@endforeach
			<tr>
				<td align="center" height="23px" style="font-weight: bold;" colspan="3">Total</td>
				<td align="center" height="23px" style="font-weight: bold;" colspan="3">{{$total}}</td>
			</tr>
		</tbody>
	</table>
</body>
</html>