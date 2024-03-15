<script>
    function activate_delete_btns() {
        ;[...document.getElementsByClassName('delete-btn')].forEach((delete_btn)=>{
            let img = delete_btn.getElementsByTagName('img')[0]
            if (img.src === window.php_vars['img_delete_off']){ delete_btn.click() }
        })
    }
</script>


<!-- f(): -->
<button type="button" class="btn" onclick="activate_delete_btns()">
    <img class='btn-icon' src="{{ asset('images/trash-can-icon.jpg') }}"/>
</button>
