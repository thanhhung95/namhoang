<!-- Modal -Form- User-->
<div class="modal fade" id="modal-form-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">THÊM TÀI KHOẢN</h4>
      </div>
      <div class="modal-body" style="background: #fbfbfb;">
        <form id="post-form">
          @csrf
          <div class="row">
            <div class="col-sm-8 form-group">
              <label class="required">Họ và tên:</label>
              <input name="name" type="text" class="form-control" >
            </div>
            <div class="col-sm-4 form-group">
              <label class="required">Phone:</label>
              <input name="phone" type="number" class="form-control" >
            </div>
            <div class="col-sm-12 form-group">
              <label class="required">Email:</label>
              <input name="email" type="email" class="form-control" placeholder="name@gmail.com">
            </div>
            <div class="col-sm-12 form-group">
              <label class="required">Password:</label>
              <input name="password" type="text" class="form-control" >
            </div>
            <div class="col-sm-12 form-group">
              <label>Địa chỉ:</label>
              <div class="input-group">
                <input type="text" value="{!! !isset($address)?"":(trim($address->diachi_chitiet)!=""?$address->diachi_chitiet.', ':'').$address->diachi_xa.', '.$address->diachi_huyen.', '.$address->diachi_tinh !!}" class="form-control" id="txtNoio" disabled>
                <span class="input-group-btn">
                  <button type="button" id="btn-address" class="btn btn-primary radius-0" data-toggle="modal" data-target="#modal-diadanh"><i class="fas fa-map-marker-alt"></i>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-6 form-group">
              <label class="required">Lever:</label>
              <select name="lever" id="" class="form-control">
                <option value="">--Chọn--</option>
                <option value="1">Admin</option>
                <option value="2">Khách</option>
              </select>
            </div>
            <div class="col-sm-6 form-group">
              <label class="required">Trạng thái:</label>
              <select name="status" id="" class="form-control">
                <option value="">--Chọn--</option>
                <option value="1">Hoạt động</option>
                <option value="0">Dừng</option>
              </select>
            </div>
          </div>
          <!-- Địa chỉ  -->
          <input type="hidden" name="diachi_quocgia" value="{!! isset($address->diachi_quocgia)?$address->diachi_quocgia:'' !!}">
          <input type="hidden" name="diachi_tinh" value="{!! isset($address->diachi_tinh)?$address->diachi_tinh:'' !!}">
          <input type="hidden" name="diachi_huyen" value="{!! isset($address->diachi_huyen)?$address->diachi_huyen:'' !!}">
          <input type="hidden" name="diachi_xa" value="{!! isset($address->diachi_xa)?$address->diachi_xa:'' !!}">
          <input type="hidden" name="diachi_chitiet" value="{!! isset($address->diachi_chitiet)?$address->diachi_chitiet:'' !!}">
          <!-- END Địa chỉ  -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        <button id="save-user" type="button" class="btn btn-sm btn-custome"><i class="fas fa-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>