import {msleep, post} from './helpers.js'


function submit_search_targets() {
    let fieldwise = {}
    ;[...document.getElementsByClassName('advanced-search-input')].forEach((col_search_input)=>{
        fieldwise[col_search_input.dataset.viewField] = col_search_input.value
    })
    return post(window.post_to_get_route_route, {
        'target_route': window.current_route,
        'search_targets': {
            'fieldwise': fieldwise,
            'tablewise': document.getElementsByClassName('search-input')[0].value
        }
    })
}


function submit_empty_search_targets() {
    let fieldwise = {}
    ;[...document.getElementsByClassName('advanced-search-input')].forEach((col_search_input)=>{
        fieldwise[col_search_input.dataset.viewField] = ''
    })

    return post(window.post_to_get_route_route, {
        'target_route': window.current_route,
        'search_targets': {
            'fieldwise': fieldwise,
            'tablewise': ''
        }
    })
}


window.submit_search_targets = submit_search_targets
window.submit_empty_search_targets = submit_empty_search_targets
