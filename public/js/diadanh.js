 /**
 *
 * Load dữ liệu cho Modal Địa danh
 *
 **/

 function getDiadanh(url,selector,seleted){
    $.ajax(
        url, // Lấy danh sách các quốc gia
        {
            type: 'GET',  // Kep one of your method
            success: function (data) {
                var html = seleted;
                data.forEach(function (item) {
                    html+='<option value="'+item.id+'">'+item.ten+'</option>';
                })
                $('select'+selector).html(html);
            },
            error: function (data) {
                console.log('lỗi load ajax: getDiadanh');
            }
        });
}

$('#modal-diadanh').on('show.bs.modal', function (e) {
    getDiadanh('api/diadanh/0','#diadanh_quocgia',''); // Lấy danh sách các quốc gia
    getDiadanh('api/diadanh/1','#diadanh_tinh','<option value="0">-- Chọn tỉnh --</option>'); // Lấy danh sách tỉnh thuộc quốc gia có id = 1
});
$(document).on('change','#diadanh_quocgia',function(){

});
$(document).on('change','#diadanh_tinh',function(){
    getDiadanh('api/diadanh/'+$(this).val(),'#diadanh_huyen','<option value="0">-- Chọn Huyện/Thị --</option>');
    $('#diadanh_xa').html('<option value="0">-- Chọn Xã/Phường --</option>');
});
$(document).on('change','#diadanh_huyen',function(){
    getDiadanh('api/diadanh/'+$(this).val(),'#diadanh_xa','<option value="0">-- Chọn Xã/Phường --</option>');
});