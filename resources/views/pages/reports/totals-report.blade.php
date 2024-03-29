<!DOCTYPE html><html lang="ru">
<script>
    window.post_to_get_route_route = '{{ route('post_to_get_route') }}'
    window.current_route = '{{ Route::current()->getName() }}'
</script>


<head>
    @include('global-head')
    <title>Общий отчет</title>

<!-- imports: -->
    @include('another.php_variables')
    <link rel="stylesheet" href="{{ asset('css/abstract/tile-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>


<body>
<table class="tile-table" data-view-fields="{{ implode(',', $view_fields) }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ mb_strtoupper($header) }}</th>
        @endforeach
    </tr>

    @foreach ($paginator as $total)
        <tr>
            <td>{{ $total->product_name }}</td>

            <td>{{ $total->purchases_totals }}</td>
            <td>{{ $total->sales_totals }}</td>
            <td>{{ $total->quantity_totals }}</td>
            <td>{{ $total->liquidating_totals }}</td>
            <td>{{ $total->inventory_totals }}</td>
            <td>{{ $total->import_totals }}</td>
        </tr>
    @endforeach
</table>


<div>{{ $paginator->links('pagination::my-pagination-links') }}</div>
@include('table-tools.search-bar', compact('search_targets', 'view_fields', 'headers'))
@include('table-tools.ordering-menu', compact('view_fields', 'headers'))

<form class="vertical-arrange" style="max-width: 200px">
    @include('report-components.report-storage-select', compact('Storage', 'report_storage'))
    <input name="begin_date" type="date" onfocusout="this.form.submit()" value="{{ $begin_date }}">
    <input name="end_date" type="date" onfocusout="this.form.submit()" value="{{ $end_date }}">
    @include('report-components.report-field-btn', compact('is_cost_report'))
</form>


<div style="height: 500px"></div>
</body>
</html>
