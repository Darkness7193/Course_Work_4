<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/dropdown.js') }}" type="module"></script>


<!-- f($model_for_route): -->
<div class="dropdown advanced-search-btn icon">
    <button type="button" onclick="toggle_dropdown_content(this)" class="drop-btn icon"></button>
    <div class="dropdown-content">
        <form method="POST">
            @csrf {{ csrf_field() }}
            <p> 1234 </p>
        </form>
    </div>
</div>