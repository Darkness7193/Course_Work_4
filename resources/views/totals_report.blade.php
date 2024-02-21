<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/beautiful-table.css') }}">
</head>
<body>

<table class="beautiful-table">

    <tr>
        <th> СКЛАД </th>
        <th> ТОВАР </th>
        <th> КОЛ-ВО ЗАКУПКИ </th>
        <th> ЦЕНА ЗАКУПКИ </th>
        <th> ЦЕНА ПРОДАЖИ </th>
        <th> ЦЕНА ПРОДАЖИ </th>
    </tr>


    @foreach ($totals as $total)
        <tr>

            <td>{{ $total->storage_name }}</td>
            <td>{{ $total->product_name }}</td>
            <td>{{ $total->total_purchases_quantity }}</td>
            <td>{{ $total->total_purchases_price }}</td>
            <td>{{ $total->total_sales_quantity }}</td>
            <td>{{ $total->total_sales_price }}</td>

        </tr>
    @endforeach

</table>

<div>
    {{ $totals->links('pagination::custom-bootstrap-5') }}
</div>


</body>
</html>
