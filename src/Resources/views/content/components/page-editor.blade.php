<h3>Content</h3>

<hr />

<form action="{{ route('admin.content::save_page') }}" method="POST" class="form-horizontal">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="field-selector" class="col-sm-2 control-label">Velden: </label>

        <div class="col-sm-10">
            <select name="block" id="field-selector" class="form-control">
                <option value="---" selected>Selecteer een veld</option>
                @foreach($blocks as $block)
                    <option value="{{ $block->getTag() }}">{{ $block->getName() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div id="step-2" style="display: none;">
        <textarea name="content" id="page-editor" rows="30" class="form-control"></textarea>

        <hr />

        <button type="submit" class="btn btn-success btn-block">Opslaan</button>
    </div>
</form>