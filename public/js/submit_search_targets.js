import { post } from './helpers.js'


function submit_filter_targets() {
    let targets = {'target': document.getElementsByClassName('search-input')[0].value}
    ;[...document.getElementsByClassName('advanced-search-input')].forEach((col_search_input)=>{
        targets[col_search_input.dataset.viewField] = col_search_input.value
    })

    return post(window.post_to_get_route_route, {
        'target_route': window.current_route,
        'filter_targets': targets
    })
}


function submit_empty_filter_targets() {
    let targets = {'target': document.getElementsByClassName('search-input')[0].value}
    ;[...document.getElementsByClassName('advanced-search-input')].forEach((col_search_input)=>{
        targets[col_search_input.dataset.viewField] = col_search_input.value
    })

    return post(window.post_to_get_route_route, {
        'target_route': window.current_route,
        'filter_targets': targets
    })
}
