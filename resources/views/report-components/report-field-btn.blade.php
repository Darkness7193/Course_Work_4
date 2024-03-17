

<!-- f($is_cost_report): -->
<form>
    <button class="report-field-btn">
        @if($is_cost_report)
            Показывать количество
        @else
            Показывать стоимость
       @endif
    </button>
    <input hidden="hidden" name="is_cost_report" value="{{ $is_cost_report }}">
</form>
