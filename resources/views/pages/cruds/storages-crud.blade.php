<!DOCTYPE html>
<html lang="ru">@include('global-head')


<!-- imports: -->
    @include('another.php_variables')
    <script src="{{ asset('js/of_crud-table/submit_changes.js') }}" type="module"></script>
    <script src="{{ asset('js/of_crud-table/delete-btn_bulk_activation.js') }}" type="module"></script>
    <script src="{{ asset('js/of_crud-table/set_first_creation_tr.js') }}" type="module"></script>
    <link rel="stylesheet" href="{{ asset('css/crud-table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<body>
<table class="crud-table" data-max-id="{{ $max_id }}" data-view-fields="{{ implode(',', $view_fields) }}" data-crud-model="{{ $Storage }}">
    <tr>
        @foreach($headers as $header)
            <th>{{ mb_strtoupper($header) }}</th>
        @endforeach

        <th>@include('crud-components.activate-delete-btns-btn')</th>
    </tr>

    @foreach ($paginator->items() ?: [$emptyRow] as $storage)
        <tr data-row-id="{{ $storage->id }}">
            <td><input type="text" value="{{ $storage->name }}" onchange="update_cell_of(this)"></td>
            <td><input type="text" value="{{ $storage->address }}" onchange="update_cell_of(this)"></td>
            <td><input type="text" step="0.01" value="{{ $storage->phone_number }}" onchange="update_cell_of(this)"></td>
            <td><input type="text" step="0.01" value="{{ $storage->email }}" onchange="update_cell_of(this)"></td>

            <td class="comment-td"><input type="text" value="{{ $storage->comment }}" onchange="update_cell_of(this)"></td>

            <td>@include('crud-components.delete-btn')</td>
        </tr>
    @endforeach

    @if ($paginator->count() < $paginator->perPage())
        <script src="{{ asset('js/of_crud-table/set_first_creation_tr.js') }}" type="module"></script>
    @endif
</table>


<div>{{ $paginator->links('pagination::my-pagination-links') }}</div>
@include('crud-components.save-btn', ['no_view_fields' => []])
@include('table-tools.search-bar', [
    'search_targets' => $search_targets,
    'view_fields' => $view_fields,
    'headers' => $headers
])
@include('table-tools.ordering-menu', [
    'view_fields' => $view_fields,
    'headers' => $headers
])

</body>
</html>
