<h3>
    <i class="fa fa-fw fa-book"></i> Orders per maand
</h3>

<hr />

<form>
    <h4>Jaren in gemiddelde</h4>

    <ul id="year-filter" class="list-inline">
        <li>
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </li>
        @foreach ($orders->keys() as $year)
            <li>
                <div class="checkbox">
                    <label>
                        <input name="years[]" type="checkbox" value="{{ $year }}"
                                {{ request('years') === null ? 'checked' : (
                                    in_array($year, request('years')) ? 'checked' : '') }}> {{ $year }}
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
</form>

<div style="height: 300px;">
    <canvas id="order-chart"></canvas>
</div>