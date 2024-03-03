

function clear_number_checkboxes() {
    ;[...document.getElementsByClassName('number-checkbox-input')].forEach((number_checkbox)=>{
        number_checkbox.value = ''
    })
}


let largest_rank = 1


function asdf(number_checkbox) {
    number_checkbox.addEventListener('mouseup', ()=>{
        if (number_checkbox.value === '') {
            number_checkbox.value = largest_rank
            largest_rank++
        } else {
            number_checkbox.value = largest_rank
        }
    })
}


;[...document.getElementsByClassName('number-checkbox-input')].forEach((number_checkbox)=>{
    asdf(number_checkbox)
})
