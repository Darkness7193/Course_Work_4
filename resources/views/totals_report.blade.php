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
        <th> КОЛ-ВО </th>
        <th> ЦЕНА </th>
    </tr>


    @foreach ($totals as $total)
        <tr>

            <td> {{ $total->storage->name }}</td>
            <td> {{ $total->product->name }}</td>
            <td> {{ $total->total_purchase_quantity }}</td>
            <td> {{ $total->total_purchase_price }}</td>

        </tr>
    @endforeach

</table>

<div>
    {{ $totals->links('pagination::custom-bootstrap-5') }}
</div>


</body>
</html>
