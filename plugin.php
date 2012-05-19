<?php 

class Products extends RWPlugin {

    public function __construct($rapidweb) {
        parent::__construct($rapidweb);
        $rapidweb->registerPagetype('products', $this);
    }

    public function do_editor_head() {
        // needs underscore too
        ?>
        <script src='rw-global/bootstrap/js/bootstrap-modal.js'></script> <!--FIXME! -->
        <script src='rw-global/backbone/backbone-min.js'></script>
        <script src='rw-global/backbone.modelbinder/Backbone.ModelBinder.min.js'></script>
        <?php
        $this->loadJavascript('editor.js');
    }

    public function getPageTypeName() {
        return 'Products';
    }

    public function the_editor_content($view) {
        include __DIR__.'/editor.php';
    }

    public function do_head() {
    }

    public function the_content($page) {
        echo "<h1>Products Go here</h1>";
        foreach($page->plugins->products->products as $product) {
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

$this->registerPlugin('Products');
