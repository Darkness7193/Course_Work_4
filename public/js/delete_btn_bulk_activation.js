import { msleep, set_is_mouse_down } from './helpers.js'

set_is_mouse_down()
function disable_context_menu(event) { event.preventDefault() }


function suppress_context_menu_once() {
    document.addEventListener('mouseup', function activate_context_menu(event) {
        event.currentTarget.removeEventListener(event.type, activate_context_menu)
        msleep(50).then(()=>{ window.removeEventListener(`contextmenu`, disable_context_menu) })
    })
}


function delete_btn_bulk_activation(element) {
    element.addEventListener("mouseenter", (event) => {
        if (is_mouse_down) {
            element.click()
            window.addEventListener(`contextmenu`, disable_context_menu)
            suppress_context_menu_once()
        }
    })
}


[...document.getElementsByClassName('delete-btn')].forEach((delete_btn)=>{
    delete_btn_bulk_activation(delete_btn)
})


