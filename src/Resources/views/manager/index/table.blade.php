<div id="companies-table-wrapper">
    <table class="table table-hover" id="companies-table">
        <thead>
        @include('admin::manager.index.table.head')
        </thead>

        <tbody>
        @include('admin::manager.index.table.body')
        </tbody>
    </table>

    <div class="text-center">
        @if ($companies->count())
            {{ $companies->appends(['filter' => $filter])->links() }}
        @endif
    </div>
</div>