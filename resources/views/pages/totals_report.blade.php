<!DOCTYPE html><html lang="ru">@include('global-head')
<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/tile-table.css') }}">


<body>
<table class="tile-table" data-view-fields="{{ implode(',', $view_fields) }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>

    @foreach ($totals as $total)
        <tr>
            <td>{{ $total->storage_name }}</td>
            <td>{{ $total->product_name }}</td>

            <td>{{ $total->total_purchases_cost }}</td>
            <td>{{ $total->total_sales_cost }}</td>
            <td>{{ $total->income }}</td>

            <td>{{ $total->total_purchases_quantity }}</td>
            <td>{{ $total->total_sales_quantity }}</td>
            <td>{{ $total->total_quantity }}</td>
        </tr>
    @endforeach
</table>


<div>{{ $totals->links('pagination::my-pagination-links') }}</div>

@include('table-tools.search-bar', ['search_target' => $search_target])

@include('table-tools.advanced-search-btn')

</body>
</html>
