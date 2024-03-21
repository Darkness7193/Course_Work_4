<!DOCTYPE html>
<html lang="ru">@include('global-head')


<!-- imports: -->
    @include('another.php_variables')
    <link rel="stylesheet" href="{{ asset('css/abstract/tile-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/abstract/report-table.css') }}">


<body>
<table class="tile-table report-table" data-view-fields="{{ implode(',', $view_fields) }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ mb_strtoupper($header) }}</th>
        @endforeach
    </tr>

    @foreach ($totals as $total)
        <tr>
            <td>{{ $total->product_name }}</td>

            <td class="ever-td">{{ $total->all_time_totals }}</td>
            <td class="year-td">{{ $total->year_totals }}</td>
            @php($seasons = ['winter-td', 'spring-td', 'summer-td', 'fall-td', 'winter-td'])
            @for ($i=1; $i<13; $i++)
                <td class="{{ $seasons[intdiv($i, 3)] }}">{{ $total->{"month_{$i}_totals"} }}</td>
            @endfor
        </tr>
    @endforeach
</table>


<div>{{ $totals->links('pagination::my-pagination-links') }}</div>
@include('table-tools.search-bar', compact('search_targets', 'view_fields', 'headers'))
@include('table-tools.ordering-menu', compact('view_fields', 'headers'))

<form class="vertical-arrange" style="max-width: 200px">
    @include('report-components.report-storage-select')
    @include('report-components.report-year-select')
    @include('report-components.report-field-btn')
    @include('report-components.report-type-select')
</form>



<div style="height: 500px"></div>
</body>
</html>