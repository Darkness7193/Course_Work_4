function toggle_dropdown_content(drop_btn) {
    let dropdown_content = drop_btn.parentNode.getElementsByClassName('dropdown-content')[0]
    if (['', 'none'].includes(dropdown_content.style.display)) {
        dropdown_content.style.display = 'block'

    } else {
        dropdown_content.style.display = 'none'
    }
}


function dropdown_focus_out (event) {
    if (event.target.matches('.drop-btn')) {
        return
    }

    let dropdowns = document.getElementsByClassName("dropdown-content");
    for (let i = 0; i < dropdowns.length; i++) {
        dropdowns[i].style.display = 'none'
    }

}

window.onclick = dropdown_focus_out
window.toggle_dropdown_content = toggle_dropdown_content
