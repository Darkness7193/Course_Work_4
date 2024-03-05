function toggle_ordering_direction(element) {
    let direction_input = element.parentNode.parentNode.getElementsByClassName('order-direction-input')[0]
    if (direction_input.value === 'asc') {
        element.style.backgroundImage = 'url(../../images/down-ordering-icon.png)'
        direction_input.value = 'desc'
    } else {
        element.style.backgroundImage = 'url(../../images/up-ordering-icon.png)'
        direction_input.value = 'asc'
    }
}


window.toggle_ordering_direction = toggle_ordering_direction
