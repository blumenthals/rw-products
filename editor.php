<link rel='products' href='<?php echo $this->productsURL ?>/products'><!-- FIXME, use pagename -->
<script type='text/html' id='productsEditorTemplate'>
    <div class='modal rwProducts-input'>
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>Add product</h3>
        </div>
        <div class="modal-body">
            <div class='upper row'>
                <div class='productImage span2'>
                    <img src=''>
                </div>
                <div class='majorDetails span3'>
                    <input type='text' name='title' placeholder='Product Title'>
                    <textarea name='description' placeholder='Product Description'></textarea>
                    <textarea name='description2' placeholder='Secondary Description'></textarea>
                </div>
                <div class='minorDetails span2'>
                    <input type='text' name='info' placeholder='Product Info'>
                    <input type='text' name='sku' placeholder='Product ID / SKU'>
                    <input type='text' name='price' placeholder='Price'>
                    <input type='text' name='weight' placeholder='Weight (in lb)'>
                </div>
            </div>
            <div class='productOptionGroups'>
            </div>
        </div>
        <div class="modal-footer">
            <button class='btn addOptionGroup'>Add Option</button>
            <button class='btn uploadProductImage'>Upload Product Image</button>
            <button class='btn dump'>Dump</button>
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <a href="#" class="btn save btn-primary">Save</a>
        </div>
    </div>
</script>

<script type='text/html' id='ProductOptionGroupEditor'>
    <div class='productOptionGroup'>
        <input placeholder='Option Category Name' name='optionGroupName'><br>
        <div class='productOptions'>
        </div>
    </div>
</script>

<script type='text/html' id='ProductOptionEditor'>
    <div class='optionEntry'>
        <input name='optionName' class='optionName' placeholder='Option Name'><input name='optionPrice' class='optionPrice' placeholder='Price'>
    </div>
</script>

<script type='text/html' id='ProductFullView'>
    <div><h2 class='name'>Product Name</h2>
        <p class='description'>Description</p>
        <p><img class='image' src=''></p>
        <p>Price <span class='price'>$51.00</span></p>
        <p>Weight <span class='weight'>21 kg</span></p>
        <p>Taxable <span class='taxable'>Y</span></p>
        <div class='options'></div>
    </div>
</script>
<script type='text/html' id='ProductOptionsView'>
    <h3>Options</h3>
    <div class='option-values'>
        <p>{$option->name}: Add {$option->price}</p>
    </div>
</script>
<script type='text/html' id='ProductThumbnailView'>
    <div class='rw-product-thumbnail'>
        <img src='' class='field-image'>
        <p class='field-title'>Product Name</p>
        <p class='field-price'>Price</p>
    </div>
</script>
<div class='rw-products'>
</div>
<button class='btn' id='addproduct'>Add Product</button>
