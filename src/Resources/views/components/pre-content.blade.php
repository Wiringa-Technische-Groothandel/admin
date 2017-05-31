<div class="container-fluid" id="before-content">
    <div class="row">
        <div class="col-sm-3 animated fadeInRightBig">
            <table class="header-stat">
                <tbody>
                <tr>
                    <td class="icon" rowspan="2"><i class="fa fa-book"></i></td>
                    <th class="title">Orders</th>
                </tr>
                <tr>
                    <td class="value">{{ format_number(\WTG\Checkout\Models\Order::count()) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-sm-3 animated fadeInRightBig">
            <table class="header-stat">
                <tbody>
                <tr>
                    <td class="icon" rowspan="2"><i class="fa fa-user-circle-o"></i></td>
                    <th class="title">Gebruikers</th>
                </tr>
                <tr>
                    <td class="value">{{ format_number(\WTG\Customer\Models\Company::count()) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-sm-3 animated fadeInRightBig">
            <table class="header-stat">
                <tbody>
                <tr>
                    <td class="icon" rowspan="2"><i class="fa fa-archive"></i></td>
                    <th class="title">Producten</th>
                </tr>
                <tr>
                    <td class="value">{{ format_number(\WTG\Catalog\Models\Product::count()) }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="col-sm-3 animated fadeInRightBig">
            <table class="header-stat">
                <tbody>
                <tr>
                    <td class="icon" rowspan="2"><i class="fa fa-percent"></i></td>
                    <th class="title">Kortingen</th>
                </tr>
                <tr>
                    <td class="value">{{ format_number(\WTG\Catalog\Models\Discount::count()) }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>