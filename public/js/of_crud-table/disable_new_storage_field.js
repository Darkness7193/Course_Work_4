import { get_value } from "../helpers.js"

;[...document.getElementsByClassName('product-move-type-select')].forEach((move_type_select)=>{
    move_type_select.addEventListener('change', ()=>{
        let tr = move_type_select.parentNode.parentNode
        let new_storage_select = tr.getElementsByClassName('new-storage-select')[0]
        let is_transfering = get_value(move_type_select) === 'transfering'

        new_storage_select.disabled = !is_transfering;
    })
})
