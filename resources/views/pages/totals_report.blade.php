<!DOCTYPE html>
<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/tile-table.css') }}">


<html lang="ru">
<head>
    <meta charset="utf-8">
</head>
<body>

<table class="tile-table">

    <tr>
        <th> СКЛАД </th>
        <th> ТОВАР </th>

        <th> ЦЕНА ЗАКУПКИ </th>
        <th> ЦЕНА ПРОДАЖИ </th>
        <th> ДОХОД </th>

        <th> КОЛ-ВО ЗАКУПКИ </th>
        <th> КОЛ-ВО ПРОДАЖИ </th>
        <th> КОЛ-ВО ОСТАТКА </th>
    </tr>


    @foreach ($totals as $total)
        <tr>
            <td>{{ $total->storage_name }}</td>
            <td>{{ $total->product_name }}</td>

            <td>{{ $total->total_purchases_price }}</td>
            <td>{{ $total->total_sales_price }}</td>
            <td>{{ $total->income }}</td>

            <td>{{ $total->total_purchases_quantity }}</td>
            <td>{{ $total->total_sales_quantity }}</td>
            <td>{{ $total->total_quantity }}</td>
        </tr>
    @endforeach

</table>

<div>
    {{ $totals->links('pagination::my-pagination-links') }}
</div>


</body>
</html>