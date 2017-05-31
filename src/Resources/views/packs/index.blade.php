@extends('admin::master')

@section('document_start')
    @include('admin::packs.components.addPackForm')
@endsection

@section('content')
    <div class="container-fluid" id="packs">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                <div class="card card-2">
                    <a data-toggle="modal" data-target="#addProductPack" class="btn btn-block btn-success">
                        <i class="fa fa-plus"></i> Actiepaket toevoegen
                    </a>
                </div>
            </div>
        </div>

        @if (count($packs))
            <div class="row">
                @foreach($packs as $pack)
                    <div class="col-md-4">
                        <div class="card card-2">
                            <div class="actiepaket">
                                <div class="title">
                                    @if ($pack->product === null)
                                        Het product ({{ $pack->product_id }}) bestaat niet meer
                                    @else
                                        {{ strlen($pack->product->name) > 40 ? substr($pack->product->name, 0 , 37) . "..." : $pack->product->name }}
                                    @endif
                                </div>
                                <div class="product-list">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Aantal</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($pack->products as $product)
                                                <tr>
                                                    <td>{{ $product->product }}</td>
                                                    <td>{{ $product->amount }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="actiepaket-actions">
                                    <a href="{{ route('admin.packs::edit', ['id' =>  $pack->id]) }}" class="btn btn-primary btn-block">Aanpassen</a>
                                    <button onclick="showConfirmationModal(this)" data-id="{{ $pack->id }}" data-name="{{ $pack->name }}" class="btn btn-danger btn-block">Verwijderen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection