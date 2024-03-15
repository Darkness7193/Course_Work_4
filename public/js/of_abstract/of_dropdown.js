window.last_dropdown = null


function hide_dropdowns() {
    ;[...document.getElementsByClassName("dropdown-content")].forEach((dropdown)=>{
        dropdown.style.display = 'none'
    })
}


function toggle_dropdown_content(drop_btn) {
    let dropdown_content = drop_btn.parentNode.getElementsByClassName('dropdown-content')[0]
    let is_dropdown_hidden = ['', 'none'].includes(dropdown_content.style.display)

    if (is_dropdown_hidden) { hide_dropdowns() } // close other dropdowns when open some of them
    dropdown_content.style.display = is_dropdown_hidden ? 'block' : 'none'
}


function hide_dropdowns_by_outside_click(event) {
    let is_outside = !event.target.closest('.dropdown')
    if (is_outside) { hide_dropdowns() }
}


document.addEventListener('click', hide_dropdowns_by_outside_click)
window.toggle_dropdown_content = toggle_dropdown_content
