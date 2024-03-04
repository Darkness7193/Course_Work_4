export function get_value(element) {
    if (element.tagName === 'INPUT') {
        return element.value
    } else if (element.className.includes('foreign-cell')) {
        return element.children[element.selectedIndex].value
    } else if (element.tagName === 'SELECT') {
        return element.children[element.selectedIndex].value
    } else {
        alert("get_value() got element, that is not input or foreign-cell")
    }
}

export function set_value(element, value) {
    if (element.tagName === 'INPUT') {
        element.value = value['value']
    } else if (element.className.includes('foreign-cell')) {
        element.children[element.children.length-1].text = value['text']
        element.children[element.selectedIndex].value = value['value']
    } else {
        alert("set_value() was get element, that is not input or foreign-cell")
    }
}

export function post(url, data) {
    let csrf = document.querySelector('meta[id="csrf-token"]').content
    if (csrf === null || csrf === undefined) {
        alert("post() don't have csrf token with id='csrf-token'")
    }

    return fetch(url, {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-Token': csrf},
        body: JSON.stringify(data)
    })
}

export function get_row_id_and_cl(element) {
    let td = element.parentNode
    let tr = td.parentNode
    return [Number(tr.dataset.rowId), td.cellIndex]
}

export function create(parent, tag) {
    let element = document.createElement(tag)
    parent.appendChild(element)
    return element
}

export function msleep (mtime) {
    return new Promise((resolve) => setTimeout(resolve, mtime));
}

export function set_by_double_keys(json, keys, value) {
    try {
        json[keys[0]][keys[1]] = value
    } catch (e) {
        if (e.name === 'TypeError') {
            json[keys[0]] = {[keys[1]]: value}
        } else {
            throw e
        }
    }
}

export function set_editors_to_empty(tr) {
    for (let i=0; i<tr.cells.length; i++) {
        let editor = tr.cells[i].querySelectorAll('input,select')[0]
        if (editor === undefined) {
            continue
        }
        set_value(editor, {'text': '', 'value': ''})
    }
}

export function is_filled(tr) {
    for (let i=0; i<tr.cells.length; i++) {
        let editor = tr.cells[i].querySelectorAll('input,select')[0]
        if (editor === undefined) { continue }

        if (get_value(editor) === '' && !editor.disabled) { return false }
    }

    return true
}

export function remove_elements_that_in_both(set, json) {
    set.forEach(element => {
        if (json.hasOwnProperty(element)) {
            delete json[element]
            set.delete(element)
        }
    });
    return [set, json]
}

export function set_is_mouse_down() {
    window.is_mouse_down = false

    document.addEventListener('mousedown', function(event) {
        window.is_mouse_down = true
    }, true)

    document.addEventListener('mouseup', function(event) {
        window.is_mouse_down = false
    }, true)
}

function disable_context_menu(event) { event.preventDefault() }
export function suppress_context_menu_once() {
    document.addEventListener(`contextmenu`, disable_context_menu)
    document.addEventListener('mouseup', function activate_context_menu(event) {
        event.currentTarget.removeEventListener(event.type, activate_context_menu)
        msleep(50).then(()=>{ document.removeEventListener(`contextmenu`, disable_context_menu) })
    })
}
