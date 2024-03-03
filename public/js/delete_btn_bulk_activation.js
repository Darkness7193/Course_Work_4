import { set_is_mouse_down, suppress_context_menu_once } from './helpers.js'

set_is_mouse_down()


function delete_btn_bulk_activation(element) {
    element.addEventListener("mouseenter", (event) => {
        if (is_mouse_down) {
            element.click()
            suppress_context_menu_once()
        }
    })
}


;[...document.getElementsByClassName('delete-btn')].forEach((delete_btn)=>{
    delete_btn_bulk_activation(delete_btn)
})


