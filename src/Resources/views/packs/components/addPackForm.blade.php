<form action="{{ route('admin.packs::add') }}" method="POST" enctype="multipart/form-data" class="form form-horizontal">
    <div class="modal fade" id="addProductPack" tabindex="-1" role="dialog" aria-labelledby="#addProductPackLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Sluiten</span></button>
                    <h4 class="modal-title" id="addProductPackLabel">Actiepakket toevoegen</h4>
                </div>

                <div class="modal-body">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="title" class="col-sm-4 control-label">Artikelnummer*</label>
                        <div class="col-sm-8">
                            <input onkeyup="getProductName(this)" class="form-control" placeholder="Artikelnummer" type="text" name="product" maxlength="100" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="col-sm-4 control-label">Naam</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" id="name" disabled>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Sluiten</button>
                    <button type="submit" class="btn btn-primary">Toevoegen</button>
                </div>
            </div>
        </div>
    </div>
</form>