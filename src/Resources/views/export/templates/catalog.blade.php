<!DOCTYPE html>
<html>
<head>
    <title>Wiringa Technische Groothandel catalogus</title>

    <style type="text/css">
        @import url(https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css);

        * {
            font-family: 'Titillium Web', sans-serif !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: bold;
        }

        h4, h6,
        b, p {
            margin: 0 auto;
        }

        h6.index_name {
            position: relative;
            right: 10000px;
            margin: 0;
            padding: 0;
            font-size: 0pt;
            top: -15px;
        }

        p.group {
            font-size: 11pt;
        }

        p.series,
        p.type {
            font-size: 10pt;
        }

        img {
            max-width: 80px;
            max-height: 80px;
        }

        .product-image {
            position: relative;
            height: 80px;
        }

        table {
            margin-bottom: 10px !important;
        }

        tr,
        .type-wrapper {
            page-break-inside: avoid;
        }

        .group-wrapper {
            page-break-after: always;
        }

        .type-wrapper {
            min-height: 80px;
        }

        th, td {
            padding: 0 8px !important;
            font-size: 7pt;
            white-space: nowrap;
        }

        a {
            color: black;
        }

        td:nth-child(1),
        th:nth-child(1) {
            width: 7%;
        }

        td:nth-child(2),
        th:nth-child(2) {
            width: 63%;
        }

        td:nth-child(3),
        th:nth-child(3) {
            width: 7%;
        }

        td:nth-child(4),
        th:nth-child(4) {
            width: 12%;
        }

        td:nth-child(5),
        th:nth-child(5) {
            width: 3%;
        }

        td:nth-child(6),
        th:nth-child(6) {
            width: 7%;
        }

        .center {
            text-align: center;
        }
    </style>

</head>
<body>
    @foreach($products as $group => $productsByGroup)
        <div class="group-wrapper center">
            <p class="group">
                <b>{{ $group }}</b>
            </p>

            @foreach($productsByGroup as $series => $productsBySeries)
                <div class="type-wrapper">
                    <div class="center">
                        <p class="series">
                            <b>{{ $series }}</b>
                        </p>
                    </div>

                    @foreach($productsBySeries as $type => $productsByType)
                        <p class="type">
                            <b>{{ $type }}</b>
                        </p>

                        <h6 class="index_name">{{ $productsByType->first()->getCatalogIndex() }}</h6>

                        <div class="row">
                            <div class="col-xs-2 product-image">
                                @if ($productsByType->first()->getImage(false) !== 'geenafbeelding.jpg')
                                    <div class="center">
                                        <img src="https://wiringa.nl/img/products/{{ $productsByType->first()->getImage(false) }}">
                                    </div>
                                @endif
                            </div>

                            <div class="col-xs-10">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Art nr.</th>
                                        <th>Naam</th>
                                        <th>Groep</th>
                                        <th>Fabrieksnr.</th>
                                        <th>PP</th>
                                        <th>Prijs</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productsByType as $product)
                                            <tr>
                                                <td>{{ $product->getSku() }}</td>
                                                <td>{{ $product->getName() }}</td>
                                                <td>{{ $product->getGroup() }}</td>
                                                <td>{{ $product->getAlternateSku() }}</td>
                                                <td>{{ ($product->refactor == 1 ? format_price_per($product->registered_per) : format_price_per($product->packed_per)) }}</td>
                                                <td>&euro; {{ format_price($product->getPrice(false)) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>