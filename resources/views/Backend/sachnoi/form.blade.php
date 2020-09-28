<!-- Modal Sach-->
<div class="modal fade" id="modal-book" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">THÔNG TIN SÁCH</h4>
      </div>
      <div class="modal-body">
        <form id="post-form">
          @csrf
          <div class="row">
            <div class="col-sm-4 form-group">
              <label>Mã sách:</label>
              <input name="book_code" type="text" class="form-control" required>
            </div>
            <div class="col-sm-4 form-group">
              <label class="required">Loại sách:</label>
              <select name="type_book" class="form-control">
                <option value="">--Chọn--</option>
                @foreach($type_book as $value)
                <option value="{{$value->symbol}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-4 form-group">
              <label class="required">Trạng thái:</label>
              <select name="status" class="form-control">
                <option value="">--Chọn--</option>
                <option value="1">Bật</option>
                <option value="0">Tắt</option>
              </select>
            </div>
            <div class="col-sm-6 form-group">
              <label class="required">Thể loại:</label>
              <select name="category" id="category" class="form-control">
                <option value="">--Thể loại--</option>
                @foreach($category as $value)
                <option value="{{$value->symbol}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-6 form-group">
              <label class="required">Lĩnh vực:</label>
              <select name="field" id="field" class="form-control">
                <option value="">--Lĩnh vực--</option>
                @foreach($field as $value)
                <option value="{{$value->symbol}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-12 form-group">
              <label class="required">Tên:</label>
              <input name="name" type="text" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
              <label>Tác giả:</label>
              <input name="author" type="text" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
              <label class="required">Nhà xuất bản:</label>
              <select name="producer" id="producer" class="form-control">
                <option value="">--Nhà xuất bản--</option>
                @foreach($producer as $value)
                <option value="{{$value->symbol}}">{{$value->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3 form-group">
              <label class="required">Năm xuất bản:</label>
              <input name="producer_year" type="number" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
              <label>Số trang:</label>
              <input name="page" type="number" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
              <label>Khổ:</label>
              <input name="size" type="text" class="form-control">
            </div>
            <div class="col-sm-3 form-group">
              <label class="required">Giá(VNĐ):</label>
              <input name="price" type="number" class="form-control">
            </div>
          </div>
          <input name="id" type="hidden" value="0">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        <button id="save-book" type="button" class="btn btn-sm btn-custome"><i class="fas fa-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>