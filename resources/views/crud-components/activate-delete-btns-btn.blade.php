<script>
    function activate_all_delete_btn() {
        ;[...document.getElementsByClassName('delete-btn')].forEach((delete_btn)=>{
            let img = delete_btn.getElementsByTagName('img')[0]
            if (img.src === window.img_delete_off){ delete_btn.click() }
        })
    }
</script>


<!-- f(): -->
<button type="button" class="btn" onclick="activate_all_delete_btn()">
    <img class='btn-icon' src="{{ asset('images/delete-off.png') }}"/>
</button>
