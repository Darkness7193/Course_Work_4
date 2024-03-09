

<!-- f($used_years, $report_year): -->
<form>
    <select style="width: 200px;" name="report_year" onchange="this.form.submit()">
        @foreach ($used_years as $used_year)
            <option value="{{ $used_year }}">{{ $used_year }} год</option>
        @endforeach

        <option selected="selected" hidden="hidden" value="{{ $report_year }}">
            @if ($report_year)
                {{ $report_year }} год
            @else
                Не имеет годов поставок
            @endif
        </option>
    </select>
</form>
