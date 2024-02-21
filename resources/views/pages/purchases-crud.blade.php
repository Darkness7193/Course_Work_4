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
        <th> ПОСТУПИЛО</th>
        <th> ТОВАР</th>
        <th> КОЛ-ВО</th>
        <th> ЦЕНА</th>
        <th> СКЛАД</th>
        <th> КОММЕНТАРИЙ</th>
    </tr>

    @foreach ($purchases as $purchase)
        @include('product-move-crud-tr', [
            'row' => $purchase,
            'products' => $products,
            'storages' => $storages
        ])
    @endforeach

    @if ($purchases->count() < $purchases->perPage())
        <script type="module">
            import {append_empty_tr, auto_new_tr} from '{{ asset('js/auto_new_tr.js') }}'

            let db_editor = document.getElementsByClassName('crud-table')[0]
            let last_tr = append_empty_tr(db_editor)
            last_tr.onchange = () => {
                auto_new_tr('{{ route('product_moves.create') }}')
            }
        </script>
    @endif

</table>

<div>{{ $purchases->links('pagination::my-pagination-links') }}</div>

<button
    id="save-btn"
    type="button"
    onclick="submit_changes(
        '{{ route('product_moves.bulk_update_or_create') }}',
        '{{ route('product_moves.bulk_delete') }}',
        'purchasing'
    )"
    > Сохранить
</button>

@include('table-tools.search-bar', [
    'model_for_route' => 'product_moves.purchases_crud'
])
</body>
</html>
