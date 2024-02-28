<!-- imports: -->
    <script src="{{ asset('js/submit_changes.js') }}" type="module"></script>


<!-- f($no_view_fields): -->
<button
    id="save-btn"
    type="button"
    onclick="submit_changes('{{ json_encode($no_view_fields) }}')"
    > Сохранить
</button>
