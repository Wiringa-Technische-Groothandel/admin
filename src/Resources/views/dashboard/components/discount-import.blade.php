@if ($discount_import->error)
    <h3>
        <i class="fa fa-fw fa-exclamation-triangle"></i> Korting import
    </h3>
@else
    <h3>
        <i class="fa fa-fw fa-check-circle"></i> Korting import
    </h3>
@endif

<hr />

<table class="table">
    <colgroup>
        <col width="15%">
        <col width="85%">
    </colgroup>
    <tbody>
        <tr>
            <td>Laatste update</td>
            <td>{{ $discount_import->updated_at->getTimestamp() === -62169984000 ? $discount_import->created_at : $discount_import->updated_at }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{!! $discount_import->getValue() !!}</td>
        </tr>
    </tbody>
</table>