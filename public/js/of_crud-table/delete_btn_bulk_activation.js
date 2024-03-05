import { activation_by_hold_mouse } from '../helpers.js'


;[...document.getElementsByClassName('delete-btn')].forEach((delete_btn)=>{
    activation_by_hold_mouse(delete_btn)
})


