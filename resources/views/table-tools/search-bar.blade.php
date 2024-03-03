<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/table-tools/search-bar.css') }}">



<!-- f($search_target, $view_fields, $headers): -->
<form class="search-bar vertical-arrange vertical-center"
    method="post"
    action="{{ route('product_moves.set_filter', ['target_route' => Route::current()->getName()]) }}"
>   @csrf

    <div class="default-input-wrapper"><button name="action" value="search"></button></div>

    @include('table-tools.fieldwise-search-btn', ['view_fields' => $view_fields,'headers' => $headers])
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
