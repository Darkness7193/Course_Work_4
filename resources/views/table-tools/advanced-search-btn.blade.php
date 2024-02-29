<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/dropdown.js') }}" type="module"></script>


<!-- f($view_fields, $headers): -->
<div class="dropdown advanced-search-btn icon">
    <button class="drop-btn icon" type="button" onclick="toggle_dropdown_content(this)"></button>
    <div class="dropdown-content">
        <form method="POST">
            @csrf {{ csrf_field() }}
            @foreach($view_fields as $rw => $view_field)
                <input class="" type="text" placeholder="{{ $headers[$rw] }}" name="search_target" autofocus
                       @isset($search_target) value="{{ $search_target }}" @endif>
            @endforeach
        </form>
    </div>
</div>
