<?php 

class ProductsLite extends RWPlugin {

    public function __construct($rapidweb) {
        parent::__construct($rapidweb);
        $rapidweb->register_pagetype('products-lite', $this);
    }

    public function do_editor_head() {
        ?>
<script>
    jQuery(document).ready(function($) {
        if(!pagedata.plugins.productsLite) pagedata.plugins.productsLite = {};
        if(!pagedata.plugins.productsLite.products) pagedata.plugins.productsLite.products = [];

        var productTemplate = {
            name: "Product Name Here",
            id: "productID",
            price: "$0.00",
            taxable: false,
            weight: "15 lb",
            options: {
                Category: {
                    name: "Option Name",
                    price: "$0.00"
                }
            }
        }

        var ta = $('textarea[name=productsLite]')

        var validate = function validate() {
            try {
                pagedata.plugins.productsLite = JSON.parse(this.value)
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
            pagedata.plugins.productsLite = data
        }

        ta.change(validate)
        ta.keyup(validate)

        update(pagedata.plugins.productsLite)

        $('#addproduct').click(function(ev) {
            ev.preventDefault();
            pagedata.plugins.productsLite.products.push(productTemplate)
            update(pagedata.plugins.productsLite)
        })
    })
</script>
<style>
textarea[name=productsLite] { width: 100%; height: 20em; }
</style>
        <?php
    }

    public function getPageTypeName() {
        return 'Products';
    }

    public function the_editor_content($view) {
        echo "<button id='addproduct'>Add Product</button>";
        echo "<div id='status'>Valid</div>";
        echo "<textarea name='productsLite'>Loading, please wait</textarea>";
    }

    public function do_head() {
    }

    public function the_content($page) {
        echo "<h1>Products Go here</h1>";
        foreach($page->plugins->productsLite->products as $product) {
            $taxable = $product->taxable ? 'Y' : 'N';
            if($product->imageURL) {
                $img = "<p><img src='{$product->imageURL}'></p>";
            }
            print("<div id='{$product->sku}'><h2>{$product->name}</h2>
                <p>{$product->description}</p>
                $img
                <p>Price {$product->price}</p>
                <p>Weight {$product->weight}</p>
                <p>Taxable {$taxable}</p>");
            if(!empty($product->options)) {
                print("<h3>Options</h3>");
                foreach($product->options as $option) {
                    print("<p>{$option->name}: Add {$option->price}</p>");
                }
            }
            print("</div>");
        }
    }
}

$this->registerPlugin('ProductsLite');
