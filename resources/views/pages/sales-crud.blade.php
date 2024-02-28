<!DOCTYPE html>
<!-- imports: -->
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
</head>
<body
    data-img-delete-on="{{ asset('images/delete-on.png') }}"
    data-img-delete-off="{{ asset('images/delete-off.png') }}"
>

<table
    class="crud-table"
    data-view-fields="{{ implode(',', $view_fields) }}"
    data-max-id="{{ $max_id }}"
>
    <tr>
        <th> ПРОДАНО </th>

        <th> ТОВАР </th>
        <th> КОЛ-ВО </th>
        <th> ЦЕНА </th>

        <th> СКЛАД </th>
        <th> КОММЕНТАРИЙ </th>
    </tr>


    @foreach ($sales as $sale)
        <tr data-row-id="{{ $sale->id }}">

            <td><input type="date" value="{{ $sale->date->toDateString() }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.foreign-cell', [
                'selected_foreign_row' => $sale->product,
                'foreign_rows' => $products
            ])</td>

            <td><input type="number" value="{{ $sale->quantity }}" onchange="update_cell_of(this)"></td>
            <td><input type="number" step="0.01" value="{{ $sale->price }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.foreign-cell', [
                'selected_foreign_row' => $sale->storage,
                'foreign_rows' => $storages
            ])</td>

            <td class="comment-col"><input type="text" value="{{ $sale->comment }}" onchange="update_cell_of(this)">
            </td>
            <td>
                <button
                    type="button"
                    class="delete-btn btn"
                    onclick="toggle_row_deleting(this)"
                    ><img class='btn-icon' src="{{ asset('images/delete-off.png') }}"/>
                </button>
            </td>
        </tr>
    @endforeach

    @if (($sales->count() < $sales->perPage()) || !$sales->hasPages())
        <script type="module">
            import {append_empty_tr, auto_new_tr} from '{{ asset('js/auto_new_tr.js') }}'

            let crud_table = document.getElementsByClassName('crud-table')[0]
            let last_tr = append_empty_tr(crud_table)
            last_tr.onchange = ()=>{ auto_new_tr() }
        </script>
    @endif

</table>

<div>{{ $sales->links('pagination::my-pagination-links') }}</div>

@include('crud-components.save-btn', ['product_move_type' => 'selling'])
@include('table-tools.search-bar', ['model_for_route' => 'product_moves.sales_crud'])

</body>
</html>
