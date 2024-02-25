

<!-- f($fields_defaults): -->
<button
    id="save-btn"
    type="button"
    onclick="submit_changes(
        '{{ route('product_moves.bulk_update_or_create') }}',
        '{{ route('product_moves.bulk_delete') }}',
        '{{ $product_move_type }}'
    )"
> Сохранить
</button>
