<!DOCTYPE html><html lang="ru">@include('global-head')
<script>
    window.post_to_get_route_route = '{{ route('post_to_get_route') }}'
    window.current_route = '{{ Route::current()->getName() }}'
</script>


<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/abstract/tile-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
<table class="tile-table" data-view-fields="{{ implode(',', $view_fields) }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ mb_strtoupper($header) }}</th>
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

@include('table-tools.search-bar', [
    'search_targets' => $search_targets,
    'view_fields' => $view_fields,
    'headers' => $headers
])

@include('table-tools.ordering-menu', [
    'view_fields' => $view_fields,
    'headers' => $headers
])

</body>
</html>
