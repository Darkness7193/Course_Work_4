

<!-- f($used_years, $year_of_report): -->
<form>
    <select style="width: 200px;" name="year_of_report" onchange="this.form.submit()">
        @foreach ($used_years as $used_year)
            <option value="{{ $used_year }}">{{ $used_year }} год</option>
        @endforeach

        <option selected="selected" hidden="hidden" value="{{ $year_of_report }}">
            {{ $year_of_report }} год
        </option>
    </select>
</form>
