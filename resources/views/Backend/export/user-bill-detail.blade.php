
	<table>
		<thead>
			<tr>
				<th>Mã sách</th>
				<th>Tên sách</th>
				<th>Giá(VNĐ)</th>
				<th>Số lượng</th>
				<th>Thành tiền</th>
			</tr>
		</thead>
		<tbody>
			@foreach($bill_detail as $value)
			<tr>
				<td>{{$value->Book->book_code}}</td>
				<td>{{ $value->Book->name }}</td>
				<td>{{ number_format( $value->price ,0) }}</td>
				<td>{{$value->quantity}}</td>
				<td>{{ number_format( $value->price * $value->quantity ,0) }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
