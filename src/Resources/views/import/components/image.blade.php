<h3>
    <i class="fa fa-fw fa-image"></i> Afbeeldingen
</h3>

<hr />

<form action="{{ route('admin::import.image') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="imageFile" class="col-sm-2 control-label">Bestand</label>

        <div class="col-sm-10">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                        Bladeren&hellip; <input type="file" name="imageFile" accept=".zip,image/*">
                    </span>
                </span>

                <input type="text" class="form-control" readonly id="fileName">
            </div>
        </div>
    </div>

    <span class="help-block col-sm-offset-2">ZIP/Afbeelding, max. {{ ini_get('upload_max_filesize') }}</span>

    <button type="submit" class="btn btn-success col-sm-offset-2">Afbeeldingen uploaden</button>
</form>