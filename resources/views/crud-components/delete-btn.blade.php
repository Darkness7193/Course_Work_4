

<!-- f($is_create_tr): -->
<button type="button" style="display:{{ $is_create_tr ? 'none' : 'block' }};" class="delete-btn btn" onclick="toggle_row_deleting(this)">
    <img class='btn-icon' src="{{ asset('images/delete-off.png') }}"/>
</button>
