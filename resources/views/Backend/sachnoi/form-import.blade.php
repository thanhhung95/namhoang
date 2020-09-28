<!-- Modal -->
    <div class="modal fade" id="add-book" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">THÊM SÁCH</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <select name="type" class="form-control">
                                    <option value="IMPORT_BOOK">Import Sách</option>
                                    <option value="BACK_UP">Back Up</option>
                                    <option value="EDIT_BOOK">Update Sách</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <input class="mb-5" type="file" name="file" accept=".xlsx">
                            </div>
                            <div class="col-sm-12 modal-footer mt-5">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-sm btn-custome"><i class="fas fa-check"></i> Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>