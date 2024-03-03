import { is_filled, set_editors_to_empty } from "../helpers.js"


function set_next_row_id(tr) {
    let crud_table = document.getElementsByClassName('crud-table')[0]
    tr.dataset['rowId'] = String(Number(crud_table.dataset.maxId) + 1)
    crud_table.dataset.maxId = tr.dataset.rowId
}


export function append_empty_tr(table) {
    let old_last_tr = table.rows[table.rows.length-1]
    let new_last_tr = old_last_tr.cloneNode(true)
    let delete_btn = new_last_tr.getElementsByClassName('delete-btn')[0]

    set_editors_to_empty(new_last_tr)
    set_next_row_id(new_last_tr)
    delete_btn.style.display = 'none'

    table.getElementsByTagName('tbody')[0].appendChild(new_last_tr)
    return new_last_tr
}


export function auto_new_tr() {
    let crud_table = document.getElementsByClassName('crud-table')[0]
    let old_last_tr = crud_table.rows[crud_table.rows.length-1]
    let page_is_full = window.page_count >= window.per_page

    if (is_filled(old_last_tr) && !page_is_full) {

        let new_last_tr = append_empty_tr(crud_table)
        let delete_btn = old_last_tr.getElementsByClassName('delete-btn')[0]

        new_last_tr.onchange = old_last_tr.onchange
        old_last_tr.onchange = ''
        delete_btn.style.display = 'block'

        window.page_count += 1
    }

    if (page_is_full) {
        let delete_btn = old_last_tr.getElementsByClassName('delete-btn')[0]
        delete_btn.style.display = 'block'
    }
}


window.auto_new_tr = auto_new_tr
window.set_next_row_id = set_next_row_id

