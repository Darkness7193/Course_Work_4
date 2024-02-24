<!-- imports: -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <script src="{{ asset('js/dropdown.js') }}" type="module"></script>


<!-- f($model_for_route): -->
<div class="dropdown advanced-search-btn icon">
    <button class="drop-btn icon" type="button" onclick="toggle_dropdown_content(this)"></button>
    <div class="dropdown-content">
        <form method="POST">
            @csrf {{ csrf_field() }}
            <p> 4321 </p>
        </form>
    </div>
</div>
