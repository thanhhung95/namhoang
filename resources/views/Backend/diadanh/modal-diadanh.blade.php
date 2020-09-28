<div class="modal fade" id="modal-diadanh" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-4">
                <h3 class="modal-title m-0"><i class="fas fa-map-marker-alt"></i> THÔNG TIN ĐỊA CHỈ</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label class="required">Quốc gia: </label>
                        <select name="quocgia" id="diadanh_quocgia" class="form-control" required>
                            <option value="0">-- Chọn Quốc gia --</option>
                        </select>
                    </div>
                    <div class=" form-group col-sm-6">
                        <label class="required">Tỉnh/Thành: </label>
                        <select name="tinh" class="form-control" id="diadanh_tinh" required>
                            <option value="0">-- Chọn Tỉnh/Thành --</option>
                        </select>
                    </div>
                    <div class=" form-group col-sm-6">
                        <label class="required">Huyện/Thị: </label>
                        <select name="huyen" class="form-control" id="diadanh_huyen" required>
                            <option value="0">-- Chọn Huyện/Thị --</option>
                        </select>
                    </div>
                    <div class=" form-group col-sm-6">
                        <label class="required">Xã/Phường: </label>
                        <select name="xa" class="form-control" id="diadanh_xa" required>
                            <option value="0">-- Chọn Xã/phường --</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="required">Số nhà/Tổ/Xóm/Ngõ/Thôn,...:</label>
                        <textarea name="chitiet" id="diadanh_chitiet" rows="3" class="form-control" placeholder="vd: SN 198, Tổ 32"></textarea>
                    </div>
                    <div class="form-group col-sm-12 m-0">
                        <label class="required">Chú ý: các mục có dấu </label> là bắt buộc.
                    </div>

                </div>
            </div>
            <div class="modal-footer p-4">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <button type="button" class="btn btn-custome btn-sm" id="btn_modal_chondiadanh" data-dismiss="modal"><i class="fas fa-check"></i>  Save</button>
            </div>
        </div>
    </div>
</div>