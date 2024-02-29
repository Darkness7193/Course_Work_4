<script>
    function activate_all_delete_btn() {
        ;[...document.getElementsByClassName('delete-btn')].forEach((delete_btn)=>{
            delete_btn.click()
        })
    }
</script>


<!-- f(): -->
<button type="button" class="btn" onclick="activate_all_delete_btn()">
    <img class='btn-icon' src="{{ asset('images/delete-off.png') }}"/>
</button>
