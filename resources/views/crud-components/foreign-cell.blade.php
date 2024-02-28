<!-- imports: -->
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>


<!-- f($selected_foreign_row, $foreign_rows): -->
<select class="foreign-cell" data-foreign-id="{{ $selected_foreign_row->id ?? ''}}" onchange="update_cell_of(this)" {{ $parameters ?? '' }}>
    @foreach ($foreign_rows as $foreign_row)
        <option data-foreign-id="{{ $foreign_row->id ?? '' }}">{{ $foreign_row->name }}</option>
    @endforeach

    <option selected="selected" hidden="hidden">{{ $selected_foreign_row->name ?? '' }}</option>
</select>

