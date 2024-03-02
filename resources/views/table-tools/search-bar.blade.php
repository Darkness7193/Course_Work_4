<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/table-tools/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/submit_search_targets.js') }}" type="module"></script>


<!-- f($search_target): -->

<div>
    <button class="icon anti-search-btn" type="submit" value=""></button>
    <button class="icon search-btn" onclick="submit_search_targets()" type="submit"></button>
    <input class="search-input" type="text" placeholder="Фильтр" autofocus
        value="{{ $search_targets['tablewise'] ?? '' }}"
    >
</div>


