

<!-- f($no_view_fields): -->
<button
    id="save-btn"
    type="button"
    onclick="submit_changes(
        '{{ route('product_moves.bulk_update_or_create') }}',
        '{{ route('product_moves.bulk_delete') }}',
        '{{ json_encode($no_view_fields) }}'
    )"
    > Сохранить
</button>
