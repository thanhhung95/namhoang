function Filter(url,type,selector,seleted){
	$.ajax(
        url, // Lấy danh sách các quốc gia
        {
            type: 'POST',  // Kep one of your method
            data: {
            	'X-CSRF-TOKEN'	: $('meta[name="csrf-token"]').attr('content'),
            	type			: type,
            	type_book		: $('#type-book').val() ? $('#type-book').val() : 0,
            	category		: $('#category').val() ? $('#category').val() : 0,
            	field			: $('#field').val() ? $('#field').val() : 0,
                producer        : $('#producer').val() ? $('#producer').val() : 0,
            },
            success: function (data) {
                var html = seleted;
                data.forEach(function (item) {
                    html+='<option value="'+item.symbol+'">'+item.name+'</option>';
                })
                $('.filter '+selector).html(html);
            },
            error: function (data) {
                console.log('lỗi load ajax: Filter');
            }
        });
}
$(document).ready(function(){
    Filter('api/filter','CATEGORY','#category','<option value="0">-- Thể loại --</option>'); // Lấy danh sách category
    Filter('api/filter','PRODUCER','#producer','<option value="0">-- Nhà xuất bản --</option>');	//Lấy danh sách nhà xuất bản
});
$(document).on('change','#category',function(){
	$('.filter #field').val(0);
	$('.filter #producer').val(0);
    Filter('api/filter','FIELD','#field','<option value="0">-- Lĩnh vực --</option>');	//Lấy danh sách lĩnh vực
    Filter('api/filter','PRODUCER','#producer','<option value="0">-- Nhà xuất bản --</option>');   //Lấy danh sách nhà xuất bản
});
$(document).on('change','#field',function(){
	$('.filter #producer').val(0);
    Filter('api/filter','PRODUCER','#producer','<option value="0">-- Nhà xuất bản --</option>');   //Lấy danh sách nhà xuất bản
});
