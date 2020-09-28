<table>
	<thead>
		<tr>
			<th>Tên sách</th>
			<th>Đơn giá</th>
			<th>Số lượng</th>
			<th>Thành tiền</th>
		</tr>
	</thead>
	<tbody>
		@foreach($cart as $value)
		<tr>
			<td>{{ $value->name }}</td>
			<td>{{ $value->price }}</td>
			<td>{{ $value->quantity }}</td>
			<td>{{ $value->price * $value->quantity }}</td>
		</tr>
		@endforeach
	</tbody>
</table>

