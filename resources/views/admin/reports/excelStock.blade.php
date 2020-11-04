<!DOCTYPE html>
<html>
<head>
	<title>Income</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<th colspan="6" style="border: 2px solid black;" height="23px" align="center">Laporan Ketersedian Stok Barang</th>
			</tr>
			<tr>
				<th colspan="6" style="border: 2px solid black;" height="23px" align="center">Periode {{$by}}</th>
			</tr>
			<tr>
				<th colspan="3" height="23px" style="border: 2px solid black;">Nama Barang</th>
				<th colspan="3" height="23px" style="border: 2px solid black;">Stok</th>
			</tr>
		</thead>
		<tbody>
			<?php $total=0; ?>
			@foreach($data as $key => $value)
				<tr>
					<td style="border: 2px solid black;" height="23px" colspan="3">{{$value['name']}}</td>
					<td style="border: 2px solid black;" height="23px" colspan="3">{{$value['stock']}}</td>
				</tr>
				<?php $total+=$value['stock']; ?>
			@endforeach
			<tr>
				<td align="center" height="23px" style="border: 2px solid black;font-weight: bold;" colspan="3">Total Stok</td>
				<td align="center" height="23px" style="border: 2px solid black;font-weight: bold;" colspan="3">{{$total}}</td>
			</tr>
		</tbody>
	</table>
</body>
</html>