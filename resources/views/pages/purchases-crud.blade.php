<!DOCTYPE html><html lang="ru">@include('global-head')
<script>
    window.update_or_create_in_bulk_route = '{{ route('product_moves.bulk_update_or_create') }}'
    window.delete_in_bulk_route = '{{ route('product_moves.bulk_delete') }}'
    window.img_delete_on = "{{ asset('images/delete-on.png') }}"
    window.img_delete_off = "{{ asset('images/delete-off.png') }}"
</script>


<!-- imports: -->
    <script src="{{ asset('js/auto_new_tr.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
<table class="crud-table" data-max-id="{{ $max_id }}">
    <tr>
        <th data-view-field="date">       ПОСТУПИЛО </th>

        <th data-view-field="product_id"> ТОВАР </th>
        <th data-view-field="quantity">   КОЛ-ВО </th>
        <th data-view-field="price">      ЦЕНА </th>

        <th data-view-field="storage_id"> СКЛАД </th>
        <th data-view-field="comment">    КОММЕНТАРИЙ </th>
    </tr>

    @foreach ($purchases as $purchase)
        @include('crud-components.product-move-crud-tr', [
            'row' => $purchase,
            'products' => $products,
            'storages' => $storages
        ])
    @endforeach

    @if ($purchases->count() < $purchases->perPage())
        @include('crud-components.product-move-crud-tr', [
            'row' => $emptyRow,
            'products' => $products,
            'storages' => $storages,
            'is_create_tr' => true,
        ])
        <script type="module">
            window.per_page = Number('{{ $purchases->perPage() }}')
            window.page_count = Number('{{ $purchases->count() }}')
            let crud_table = document.getElementsByClassName('crud-table')[0]
            let last_tr = crud_table.rows[crud_table.rows.length - 1]
            last_tr.onchange = () => {
                auto_new_tr()
            }
            set_next_row_id(last_tr)
        </script>
    @endif
</table>


<div>{{ $purchases->links('pagination::my-pagination-links') }}</div>

@include('crud-components.save-btn', ['no_view_fields' => [
    'product_move_type' => 'purchasing',
    'new_storage_id' => null
]])

@include('table-tools.search-bar', ['search_target' => $search_target])

@include('table-tools.advanced-search-btn')

</body>
</html>


<script src="{{ asset('js/delete_btn_bulk_activation.js') }}" type="module"></script>
