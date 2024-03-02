import { post } from './helpers.js'


function submit_search_targets() {
    let cols_targets = {}
    ;[...document.getElementsByClassName('advanced-search-input')].forEach((col_search_input)=>{
        cols_targets[col_search_input.dataset.viewField] = col_search_input.value
    })

    return post(window.post_to_get_route_route, {
        'target_route': window.current_route,
        'search_col_targets': cols_targets,
        'search_cols_target': document.getElementsByClassName('search-input')[0].value
    })
}


function submit_empty_search_targets() {
    let cols_targets = {}
    ;[...document.getElementsByClassName('advanced-search-input')].forEach((col_search_input)=>{
        cols_targets[col_search_input.dataset.viewField] = ''
    })

    return post(window.post_to_get_route_route, {
        'target_route': window.current_route,
        'search_col_targets': cols_targets,
        'search_cols_target': ''
    })
}
