import { msleep } from './helpers.js'


var is_mouse_down = false

document.addEventListener('mousedown', function(event) {
    is_mouse_down = true
    console.log('mouse_is_down')
}, true)

document.addEventListener('mouseup', function(event) {
    is_mouse_down = false
}, true)

function disable_context_menu(event) { event.preventDefault() }

function activate_by_hold_cursor_entering(element) {

    element.addEventListener("mouseenter", (event) => { if (is_mouse_down) {
        element.click()
        window.addEventListener(`contextmenu`, disable_context_menu)
        document.addEventListener('mouseup', function activate_context_menu(event) {
            event.currentTarget.removeEventListener(event.type, activate_context_menu)
            msleep(200).then(()=>{
                window.removeEventListener(`contextmenu`, disable_context_menu)
            })
        })
    } })
}


let delete_btns = document.getElementsByClassName('delete-btn')
for (let i=0, n=delete_btns.length; i<n; i++) {
    activate_by_hold_cursor_entering(delete_btns[i])
}


