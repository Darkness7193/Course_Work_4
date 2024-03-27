

function auto_price_insert(product_select) {
    let selected_option = product_select.options[product_select.selectedIndex]
    let parent_tr = product_select.parentNode.parentNode

    let purchase_price_input = parent_tr.getElementsByClassName('purchase-price-input')[0]
    let sale_price_input = parent_tr.getElementsByClassName('sale-price-input')[0]

    if (purchase_price_input) {
        purchase_price_input.value = selected_option.dataset.purchasePrice
        purchase_price_input.dispatchEvent(new Event('focusout'))
    }

    if (sale_price_input) {
        sale_price_input.value = selected_option.dataset.salePrice
        sale_price_input.dispatchEvent(new Event('focusout'))
    }
}


;[...document.getElementsByClassName('product-select')].forEach((product_select)=>{
    product_select.addEventListener('change', ()=>{ auto_price_insert(product_select) })
})
