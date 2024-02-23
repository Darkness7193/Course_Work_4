var is_mouse_down = false

document.addEventListener('mousedown', function(event) {
    is_mouse_down = true
    console.log('mouse_is_down')
}, true)

document.addEventListener('mouseup', function(event) {
    is_mouse_down = false
}, true)


function activate_by_hold_cursor_entering(elements) {

    for (let i=0, n=elements.length; i<n; i++) {
        elements[i].addEventListener("mouseenter", (event) => {
            if (is_mouse_down) {
                elements[i].click()
            }
            console.log('after_down')
        })
    }
}


let btns = document.getElementsByClassName('delete-btn')
console.log(btns)
activate_by_hold_cursor_entering(btns)