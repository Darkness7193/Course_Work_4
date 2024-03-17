

<!-- f($used_years, $report_year): -->
<select style="width: 200px;" name="report_year" onchange="this.form.submit()">
    @foreach ($used_years as $used_year)
        <option value="{{ $used_year }}">{{ $used_year }} год</option>
    @endforeach

    @if ($report_year)
        <option selected="selected" hidden="hidden" value="{{ $report_year }}">{{ $report_year }} год</option>
    @elseif (!$used_years)
        <option selected="selected" hidden="hidden" value=""> Не имеет годов поставок </option>
    @endif
</select>
