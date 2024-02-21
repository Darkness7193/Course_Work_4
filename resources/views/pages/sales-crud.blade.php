<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/db-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>
<body
    data-img-delete-on="{{ asset('images/delete-on.png') }}"
    data-img-delete-off="{{ asset('images/delete-off.png') }}"
>

<table
    class="db-editor"
    data-view-fields="{{ implode(',', $view_fields) }}"
    data-max-id="{{ $max_id }}"
>

    <tr>
        <th> ПРОДАНО</th>
        <th> ТОВАР</th>
        <th> КОЛ-ВО</th>
        <th> ЦЕНА</th>
        <th> СКЛАД</th>
        <th> КОММЕНТАРИЙ</th>
    </tr>


    @foreach ($sales as $sale)
        <tr data-row-id="{{ $sale->id }}">

            <td><input type="date" value="{{ $sale->date->toDateString() }}" onchange="add_updated_rows(this)"></td>

            <td>@include('foreign-cell', [
                'selected_foreign_row' => $sale->product,
                'foreign_rows' => $products
            ])</td>

            <td><input type="number" value="{{ $sale->quantity }}" onchange="add_updated_rows(this)"></td>
            <td><input type="number" step="0.01" value="{{ $sale->price }}" onchange="add_updated_rows(this)"></td>

            <td>@include('foreign-cell', [
                'selected_foreign_row' => $sale->storage,
                'foreign_rows' => $storages
            ])</td>

            <td class="comment-col"><input type="text" value="{{ $sale->comment }}" onchange="add_updated_rows(this)">
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

            let db_editor = document.getElementsByClassName('db-editor')[0]
            let last_tr = append_empty_tr(db_editor)
            last_tr.onchange = () => {
                auto_new_tr('{{ route('product_moves.create') }}')
            }
        </script>
    @endif

</table>

<div>
    {{ $sales->links('pagination::custom-bootstrap-5') }}
</div>
<button
    id="save-btn"
    type="button"
    onclick="submit_changes(
        '{{ route('product_moves.bulk_update_or_create') }}',
        '{{ route('product_moves.bulk_delete') }}',
        'selling'
    )"
> Сохранить
</button>

@include('table-tools.search-bar', [
    'model_for_route' => 'product_moves.purchases_crud'
])
</body>
</html>
