<!-- imports: -->
    <script src="{{ asset('js/of_crud-table/submit_changes.js') }}" type="module"></script>


<!-- f($row, $is_create_tr=undefined, $paginator): -->
<tr data-row-id="{{ $row->id }}">
    <td><input type="text" value="{{ $row->name }}" onchange="update_cell_of(this)"></td>
    <td><input type="text" value="{{ $row->manufactor }}" onchange="update_cell_of(this)"></td>
    <td><input type="number" step="0.01" value="{{ $row->purchase_price }}" onchange="update_cell_of(this)"></td>
    <td><input type="number" step="0.01" value="{{ $row->selling_price }}" onchange="update_cell_of(this)"></td>

    <td class="comment-td"><input type="text" value="{{ $row->comment }}" onchange="update_cell_of(this)"></td>
    <td><input type="number" value="{{ $row->is_to_sale }}" onchange="update_cell_of(this)"></td>

    <td>@include('crud-components.delete-btn', ['is_create_tr' => $is_create_tr ?? false ])</td>
</tr>
