<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/table-tools/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">


<!-- f($model_for_route, $search_target): -->
<div class="vertical-arrange">
    <form class="vertical-center"
        method="post"
        action="{{ route('post_to_get_route', ['target_route' => Route::current()->getName()]) }}"
    >   @csrf {{ csrf_field() }}
        <button class="icon anti-search-btn" type="submit" value=""></button>
    </form>

    <form class="search-bar"
        method="post"
        action="{{ route('post_to_get_route', ['target_route' => Route::current()->getName()]) }}"
    >   @csrf {{ csrf_field() }}
        <button class="icon search-btn" type="submit"></button>
        <input class="search-input" type="text" placeholder="Фильтр" name="search_target" autofocus
            @isset($search_target) value="{{ $search_target }}" @endif>
    </form>
</div>

