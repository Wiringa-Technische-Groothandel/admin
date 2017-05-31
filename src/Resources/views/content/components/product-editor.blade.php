<h3>Product omschrijving</h3>

<hr />

<form action="{{ route('admin.content::save_description') }}" method="POST" class="form-horizontal">

    {{ csrf_field() }}

    <div class="form-group">
        <label for="field" class="col-sm-2 control-label">Product nummer</label>

        <div class="col-sm-10">
            <input placeholder="Product nummer" id="product-number" type="number" name="product" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="field" class="col-sm-2 control-label">Omschrijving</label>

        <div class="col-sm-10">
            <textarea name="content" id="description-editor" rows="30" class="form-control"></textarea>
        </div>
    </div>

    <button class="btn btn-success" type="submit">Opslaan</button>
</form>