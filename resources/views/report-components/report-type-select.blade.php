@php($ru_report_types = [
    'quantities' => 'Отчет количеств',
    'purchasing' => 'Отчет закупок',
    'selling' => 'Отчет продаж',
    'liquidating' => 'Отчет ликвидации',
    'inventory' => 'Отчет инвентаризации',
    'transfering' => 'Отчет экспорта'
])


<!-- f($current_report_type): -->
<select name="current_report_type" onchange="this.form.submit()">
    @foreach ($ru_report_types as $report_type => $ru_report_type)
        <option value="{{ $report_type }}">{{ $ru_report_type }}</option>
    @endforeach

    <option selected="selected" hidden="hidden" value="{{ $current_report_type }}">
        {{ $ru_report_types[$current_report_type] }}
    </option>
</select>
