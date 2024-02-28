import { get_value } from "./helpers.js"

;[...document.getElementsByClassName('product-move-type-select')].forEach((move_type_select)=>{
    move_type_select.addEventListener('change', ()=>{
        let tr = move_type_select.parentNode.parentNode
        if (get_value(move_type_select) === 'transfering') {
            tr.getElementsByClassName('new-storage-select')[0].disabled = false
        } else {
            tr.getElementsByClassName('new-storage-select')[0].disabled = true
        }
    })
})
