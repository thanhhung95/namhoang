<!-- Modal -Edit- User-->
<div class="modal fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">THÔNG TIN TÀI KHOẢN</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body" style="background: #fbfbfb;">
        <form id="post-form-info">
          @csrf
          <div class="row">
            <div class="col-sm-8 form-group">
              <label>Họ và tên:</label>
              <input name="name" type="text" class="form-control" >
            </div>
            <div class="col-sm-4 form-group">
              <label>Phone:</label>
              <input name="phone" type="number" class="form-control" >
            </div>
            <div class="col-sm-12 form-group">
              <label>Email:</label>
              <input name="email" type="email" class="form-control" placeholder="name@gmail.com">
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
              <label>Lever:</label>
              <select name="lever" id="" class="form-control">
                <option value="">--Chọn--</option>
                <option value="1">Admin</option>
                <option value="2">Khách</option>
              </select>
            </div>
            <div class="col-sm-6 form-group">
              <label>Trạng thái:</label>
              <select name="status" id="" class="form-control">
                <option value="">--Chọn--</option>
                <option value="1">Hoạt động</option>
                <option value="0">Dừng</option>
              </select>
            </div>
          </div>
          <input name="id" type="hidden" value="0">
          <input name="type" type="hidden" value="INFO">
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
        <button id="save-info" type="button" class="btn btn-sm btn-custome"><i class="fas fa-check"></i> Save</button>
      </div>
      <div class="modal-body border-top" style="background: #fbfbfb;">
        <form id="post-form-password">
          @csrf
          <div class="row">
            <div class="col-sm-12 form-group">
              <label>Password:</label>
              <input name="password" type="text" class="form-control" >
            </div>
          </div>
          <input name="id" type="hidden" value="0">
          <input name="type" type="hidden" value="PASSWORD">
        </form>
      </div>
      <div class="modal-footer">
        <button id="save-password" type="button" class="btn btn-sm btn-custome"><i class="fas fa-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>