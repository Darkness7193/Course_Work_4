<!-- imports: -->
    <script src="{{ asset('js/of_crud-table/submit_changes.js') }}" type="module"></script>


<!-- f($row, $products, $storages, $is_create_tr=undefined, $paginator): -->
<tr data-row-id="{{ $row->id }}">
    <td><input type="date" value="{{ $row->date->toDateString() }}" onchange="update_cell_of(this)"></td>

    <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $row->product, 'foreign_rows' => $products])</td>
    <td><input type="number" value="{{ $row->quantity }}" onchange="update_cell_of(this)"></td>
    <td><input type="number" step="0.01" value="{{ $row->price }}" onchange="update_cell_of(this)"></td>

    <td>@include('crud-components.foreign-cell', ['selected_foreign_row' => $row->storage, 'foreign_rows' => $storages])</td>
    <td class="comment-td"><input type="text" value="{{ $row->comment }}" onchange="update_cell_of(this)"></td>

    <td>@include('crud-components.delete-btn', ['is_create_tr' => $is_create_tr ?? false ])</td>
</tr>


@if($is_create_tr ?? false)
    <script type="module">
        window.per_page = Number('{{ $paginator->perPage() }}')
        window.page_count = Number('{{ $paginator->count() }}')
        let crud_table = document.getElementsByClassName('crud-table')[0]
        let last_tr = crud_table.rows[crud_table.rows.length - 1]
        last_tr.onchange = ()=>{ auto_new_tr() }
        set_next_row_id(last_tr)
    </script>
@endif
