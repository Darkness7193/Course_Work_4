function toggle_ordering_direction(element) {
    if (element.value === 'asc') {
        element.style.backgroundImage = 'url(../../images/down-ordering-icon.png)'
        element.value = 'desc'
    } else {
        element.style.backgroundImage = 'url(../../images/up-ordering-icon.png)'
        element.value = 'asc'
    }
}


window.toggle_ordering_direction = toggle_ordering_direction
