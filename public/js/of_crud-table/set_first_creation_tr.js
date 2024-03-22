import { auto_new_tr, set_next_row_id } from "./auto_new_tr.js"


let crud_table = document.getElementsByClassName('crud-table')[0]
let last_tr = crud_table.rows[crud_table.rows.length - 1]
last_tr.onchange = ()=>{ auto_new_tr() }
set_next_row_id(last_tr)
