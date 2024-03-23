<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/table-tools/search-bar.css') }}">


<!-- f($CrudModel, $search_target, $view_fields, $headers): -->
<form class="search-bar vertical-center"
    method="post"
    action="{{ route('set_filter', ['previous_route' => Route::current()->getName()]) }}"
>   @csrf

    <div class="default-input-wrapper"><button name="action" value="search"></button></div>

    @include('table-tools.fieldwise-search-btn', compact('view_fields', 'headers'))
    <button class="icon anti-search-btn" type="submit" name="action" value="un_search"></button>
    <button class="icon search-btn" type="submit" name="action" value="search"></button>

    <input class="search-input"
        name="tablewise_search_target"
        type="text"
        placeholder="Фильтр"
        onfocus="this.select();"
        autofocus
    >
</form>
