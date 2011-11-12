<?php 

class ProductsLite extends RWPlugin {

    public function __construct($rapidweb) {
        parent::__construct($rapidweb);
        $rapidweb->register_pagetype('products-lite', $this);
    }

    public function do_editor_head() {
    }

    public function getPageTypeName() {
        return 'Products';
    }

    public function the_editor_content() {
        echo '<textarea name="productsLite"></textarea>';
    }

    public function do_head() {
    }

    public function the_content() {
    }
}

$this->registerPlugin('ProductsLite');
