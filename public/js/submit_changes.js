import { get_value, post, get_row_id_and_cl, set_by_double_keys, remove_elements_that_in_both, msleep} from "./helpers.js"


window.updated_rows = {}
window.deleted_rows = new Set([])
window.view_fields = document.getElementsByClassName('crud-table')[0].dataset.viewFields.split(',')


function update_cell_of(editor) {
    let [row_id, cl] = get_row_id_and_cl(editor)
    set_by_double_keys(updated_rows, [row_id, view_fields[cl]], get_value(editor))
}


function toggle_row_deleting(delete_btn) {
    let row_id = Number(delete_btn.parentNode.parentNode.dataset.rowId)
    let img = delete_btn.getElementsByTagName('img')[0]
    let is_add_to_delete = deleted_rows.has(row_id)

    if (is_add_to_delete) {
        deleted_rows.delete(row_id)
        img.src = document.body.dataset.imgDeleteOff
    } else {
        deleted_rows.add(row_id)
        img.src = document.body.dataset.imgDeleteOn
    }
}


function submit_changes(update_controller, bulk_delete_controller, no_view_fields) {
    [deleted_rows, updated_rows] = remove_elements_that_in_both(deleted_rows, updated_rows)

    post(update_controller, {'updated_rows': updated_rows, 'no_view_fields': JSON.parse(no_view_fields)})
    post(bulk_delete_controller, {'deleted_rows': Array.from(deleted_rows)})

    msleep(100).then(() => { location.reload(); })
}


window.update_cell_of = update_cell_of
window.toggle_row_deleting = toggle_row_deleting
window.submit_changes = submit_changes
