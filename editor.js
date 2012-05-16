(function(){
    function Product() {
    }

    Product.prototype = {

    }

    jQuery(function($) {
        if(!pagedata.plugins.products) pagedata.plugins.products= {};
        if(!pagedata.plugins.products.products) pagedata.plugins.products.products = [];

        var productTemplate = {
            name: "Product Name Here",
            id: "productID",
            price: "0.00",
            taxable: false,
            weight: "15",
            imageURL: "",
            options: {
                Category: [ 
                    {
                        name: "Option Name",
                        price: "0.00"
                    }
                ]
            }
        }

        var ta = $('textarea[name=products]')

        var validate = function validate() {
            try {
                pagedata.plugins.products= JSON.parse(this.value)
                $('#status').text('Valid')
                $('input,button').attr('disabled', null);
            } catch(e) {
                $('#status').text('invalid')
                $('input,button').attr('disabled', 'disabled');
            }
        }

        var update = function update(data) {
            ta.attr('disabled', null)
            ta.val(JSON.stringify(data, undefined, 1))
            validate.apply(ta.get(0))
            pagedata.plugins.products= data
        }

        ta.change(validate)
        ta.keyup(validate)

        update(pagedata.plugins.products)
        var editor = $('.rwProducts-input')
        editor.modal({show: false}).hide();

        editor.find('.addOption').click(function(ev) {
            console.log('adding')
            editor.find('.productOptions').append($('#optionTemplate').html())
        })

        $('#addproduct').click(function(ev) {
            editor.modal('show')
            ev.preventDefault();
            pagedata.plugins.products.products.push(productTemplate)
            update(pagedata.plugins.products)
        })
    })
})();
