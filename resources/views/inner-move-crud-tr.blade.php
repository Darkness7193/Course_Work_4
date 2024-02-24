<!-- imports: -->
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>


<!-- f($row, $products, $storages, $inner_move_types): -->
<tr data-row-id="{{ $row->id}}">
    <td><input type="date" value="{{ $row->date->toDateString() }}" onchange="add_updated_rows(this)"></td>

    <td><select class="" onchange="add_updated_rows(this)">
        <option value="liquidation"> Ликвидация </option>
        <option value="inventory"> Инвенторизация </option>
        <option value="transfering"> Перевоз </option>

        <option value="{{ $row->product_move_type }}" selected="selected" hidden="hidden">{{ $row->product_move_type }}</option>
    </select></td>

    <td>@include('foreign-cell', ['selected_foreign_row' => $row->start_storage, 'foreign_rows' => $storages])</td>
    <td>@include('foreign-cell', ['selected_foreign_row' => $row->end_storage, 'foreign_rows' => $storages])</td>

    <td>@include('foreign-cell', ['selected_foreign_row' => $row->product, 'foreign_rows' => $products])</td>
    <td><input type="number" value="{{ $row->quantity }}" onchange="add_updated_rows(this)"></td>
    <td><input type="number" step="0.01" value="{{ $row->price }}" onchange="add_updated_rows(this)"></td>

    <td class="comment-col"><input type="text" value="{{ $row->comment }}" onchange="add_updated_rows(this)"></td>

    <td><button type="button" @isset($is_create_tr) style="display:none;" @endif class="delete-btn btn" onclick="toggle_row_deleting(this)">
        <img class='btn-icon' src="{{ asset('images/delete-off.png') }}"/>
    </button></td>
</tr>
