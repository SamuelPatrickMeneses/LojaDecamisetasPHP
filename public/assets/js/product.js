function getGrid({data}){
    let size = $('.grid-size-input:checked').val();
    let color = $('.grid-color-input:checked').val();
    let gender = $('.grid-gender-input:checked').val();
    let label = `${size}/${color}/${gender}`;
    return data[label];
}
function updateForm(dataCorelate){
    
    let grid = getGrid(dataCorelate);
    if (grid) {
        $('#variantId').val(grid.variant_id);
        $('.price-view').text(
            new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(grid.price)
        );
        $('#quantity').attr('max',grid.quantity);

        $('span.max-quantity').text(grid.quantity);
    } else {
        $('#variantId').val(0);
        $('.price-view').text('');
        $('#quantity').attr('max',0);
        $('#quantity').val(0);
        $('span.max-quantity').text(0);
    }
}


function productFrom(dataCorelate) {
    if ($('#product-sale-form').length === 1) {
        let ajustByColor = () => {
            let inputs = $('input.grid-gender-input')
            inputs.attr('disabled', false);
            inputs.attr('checked', false); 
            let genders = dataCorelate[$('.grid-color-input:checked').val()];
            let genderKeys = Object.keys(genders);
            inputs.map((i, e) => {
                e.checked = genderKeys[0] === e.value;
                e.disabled = !genders[e.value];
            });
            inputs[0].click();
        }
        let ajustByGender = (event) => {
            let inputs = $('input.grid-size-input')
            inputs.attr('disabled', false);
            inputs.attr('checked', false);
            let sizes = dataCorelate[$('.grid-color-input:checked').val()][event.target.value];
            let sizeKeys = Object.keys(sizes);
            inputs.map((i, e) =>{
                e.checked = sizeKeys[0] === e.value;
                e.disabled = !sizes[e.value];
            });
        }

        let colorIputs = $('input.grid-color-input').on('click', ajustByColor);
        $('input.grid-gender-input').on('click', ajustByGender);
        $('input.form-check-input').on('click', null, dataCorelate, updateForm);
        colorIputs[0].click();
    }
}
export default productFrom;