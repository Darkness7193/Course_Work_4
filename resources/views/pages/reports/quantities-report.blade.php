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
@include('table-tools.search-bar', [
    'search_targets' => $search_targets,
    'view_fields' => $view_fields,
    'headers' => $headers
])
@include('table-tools.ordering-menu', [
    'view_fields' => $view_fields,
    'headers' => $headers
])
<form>
    @include('report-components.report-storage-select', ['Storage' => $Storage, 'report_storage' => $report_storage])
    @include('report-components.report-year-select', ['used_years' => $used_years, 'report_year' => $report_year])
    @include('report-components.report-field-btn', ['is_cost_report' => $is_cost_report])
    <select name="report_type" onchange="this.form.submit()">
        <option value="quantities"> Отчет количеств </option>
        <option value="purchasing"> Отчет закупок </option>
        <option value="selling"> Отчет продаж </option>
        <option value="liquidating"> Отчет ликвидации </option>
        <option value="inventory"> Отчет инвентаризации </option>

        <option selected="selected" hidden="hidden" value="{{ $report_type }}">{{ $report_type }}</option>
    </select>
</form>



<div style="height: 500px"></div>
</body>
</html>
