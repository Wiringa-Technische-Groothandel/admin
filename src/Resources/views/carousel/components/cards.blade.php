<div class="row">
    <?php $iteration = 1; ?>
    @foreach($carouselData as $slide)
        <div class="col-sm-6 col-md-4">
            <div class="card card-2">
                <div class="thumbnail">
                    <img src="{{ asset('img/carousel/'.$slide['Image']) }}" alt="{{ $slide['Image'] }}" style="height: 300px">
                </div>

                <div class="caption">
                    <h3>{{ $slide['Title'] }}</h3>
                    <p>{{ $slide['Caption'] }}</p>
                </div>

                <form action="{{ route('admin.carousel::edit', [ 'id' => $slide['id'] ]) }}" method="POST" role="form">
                    {{ csrf_field() }}

                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-pencil"></i></button>
                        </span>

                        <input type="number" name="order" value="{{ $slide['Order'] }}" class="form-control" placeholder="Slide nummer" aria-describedby="descr" required>
                        <span class="input-group-addon" id="descr">Slide nr</span>
                    </div>
                </form>

                <br />

                <a href="{{ route('admin.carousel::delete', ['id' => $slide['id']]) }}" class="btn btn-danger btn-block" role="button">
                    <i class="fa fa-remove"></i> Verwijderen
                </a>
            </div>
        </div>

        @if ($iteration % 3 === 0)
            <div class="clearfix visible-md visible-lg"></div>
            <br class="visible-md visible-lg" />
        @endif

        @if ($iteration % 2 === 0)
            <div class="clearfix visible-xs visible-sm"></div>
            <br class="visible-sm" />
        @endif

        <br class="visible-xs" />

        <?php $iteration++; ?>
    @endforeach
</div>