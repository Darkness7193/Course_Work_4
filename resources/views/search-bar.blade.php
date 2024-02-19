<!DOCTYPE html>
<link rel="stylesheet" href="{{ asset('css/search-bar.css') }}">


<!-- f($model_for_route) -->
<form class="search-bar" method="post"
    action="{{ route('post_to_get_route', ['target_route' => Route::current()->getName()]) }}"
>
    @csrf {{ csrf_field() }}
    <button type="submit" value="" class="icon anti-search-btn"></button>
    <button type="submit" class="icon search-btn"></button>
    <input class="search-input" type="text" placeholder="Фильтр" name="search_target" autofocus>
</form>
