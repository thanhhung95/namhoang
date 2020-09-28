<!-- Modal-Form-Producer-->
<div class="modal fade" id="modal-form-producer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="producer-title" class="modal-title">THÔNG TIN NHÀ XUẤT BẢN</h4>
      </div>
      <div class="modal-body" style="background: #fbfbfb;">
        <div class="row">
          <form id="post-form-producer">
            @csrf
            <div class="col-sm-12 form-group">
              <label class="required">Tên:</label>
              <input type="text" name="name" class="form-control">
            </div>
            <div class="col-sm-12 form-group">
              <label class="required">Ký hiệu:</label>
              <input type="text" name="symbol" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
              <label>Website:</label>
              <input type="text" name="website" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
              <label>Phone:</label>
              <input type="number" name="phone" class="form-control" min="1">
            </div>
            <div class="col-sm-6 form-group">
              <label>Email:</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
              <label>Địa chỉ:</label>
              <input type="text" name="address" class="form-control">
            </div>
            <input name="id" type="hidden" value="">
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
        <button id="save-producer" type="button" class="btn btn-sm btn-custome"><i class="fas fa-check"></i> Save</button>
      </div>
    </div>
  </div>
</div>