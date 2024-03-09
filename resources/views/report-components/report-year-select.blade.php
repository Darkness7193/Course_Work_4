

<!-- f($used_years, $report_year): -->
<form>
    <select style="width: 200px;" name="year_of_report" onchange="this.form.submit()">
        @foreach ($used_years as $used_year)
            <option value="{{ $used_year }}">{{ $used_year }} год</option>
        @endforeach

        <option selected="selected" hidden="hidden" value="{{ $report_year }}">
            {{ $report_year }} год
        </option>
    </select>
</form>
