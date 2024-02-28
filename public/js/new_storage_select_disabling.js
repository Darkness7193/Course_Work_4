import { get_value, set_value } from "./helpers.js"

;[...document.getElementsByClassName('product-move-type-select')].forEach((move_type_select)=>{
    move_type_select.addEventListener('change', ()=>{
        let tr = move_type_select.parentNode.parentNode
        let new_storage_select = tr.getElementsByClassName('new-storage-select')[0]
        if (get_value(move_type_select) === 'transfering') {
            new_storage_select.disabled = false
        } else {
            new_storage_select.disabled = true
            set_value(new_storage_select, {'value': ''})
        }
    })
})
