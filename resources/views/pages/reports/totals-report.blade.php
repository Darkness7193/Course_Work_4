<!DOCTYPE html>
<html lang="ru">@include('global-head')
<script>
    window.post_to_get_route_route = '{{ route('post_to_get_route') }}'
    window.current_route = '{{ Route::current()->getName() }}'
</script>


<!-- imports: -->
    @include('another.php_variables')
    <link rel="stylesheet" href="{{ asset('css/abstract/tile-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
<table class="tile-table" data-view-fields="{{ implode(',', $view_fields) }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ mb_strtoupper($header) }}</th>
        @endforeach
    </tr>

    @foreach ($paginator as $total)
        <tr>
            <td>{{ $total->storage_name }}</td>
            <td>{{ $total->product_name }}</td>

            <td>{{ $total->purchases_totals }}</td>
            <td>{{ $total->sales_totals }}</td>
            <td>{{ $total->quantity_totals }}</td>
        </tr>
    @endforeach
</table>


<div>{{ $paginator->links('pagination::my-pagination-links') }}</div>
@include('table-tools.search-bar', compact('search_targets', 'view_fields', 'headers'))
@include('table-tools.ordering-menu', compact('view_fields', 'headers'))

<form class="vertical-arrange" style="max-width: 200px">
    @include('report-components.report-storage-select', compact('Storage', 'report_storage'))
    @include('report-components.report-year-select', compact('used_years', 'report_year'))
    @include('report-components.report-field-btn', compact('is_cost_report'))
</form>


<div style="height: 500px"></div>
</body>
</html>
