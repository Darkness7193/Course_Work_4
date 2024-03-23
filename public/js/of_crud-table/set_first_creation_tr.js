import { auto_new_tr, set_next_row_id } from "./auto_new_tr.js"


function set_first_creation_tr() {
    let crud_table = document.getElementsByClassName('crud-table')[0]
    auto_new_tr()

    let creation_tr = crud_table.rows[crud_table.rows.length - 1]
    creation_tr.onchange = ()=>{ auto_new_tr() }
    set_next_row_id(creation_tr)
}


set_first_creation_tr()
