<link rel='products' href='<?php echo $this->productsURL ?>/<?php echo $view->page->pagename ?>'>
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
            <form action='<?php echo $this->rapidweb->getRouteNamed('gallery-file-upload')->url; ?>' method='POST' class='file-upload btn' target='fileUploadFrame' enctype='multipart/form-data'>
                <input type='hidden' name='pagename' value='<?php echo $view->page->pagename; ?>'>
                <label>Upload Product Image</label><input type='file' name='img'><iframe id='fileUploadFrame'></iframe>
            </form>
            <button class='btn dump'>Debug Dump</button>
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
        <button class='doHide'>#</button>
        <button class='doDelete'>X</button>
        <img src='' class='image'>
        <p class='field-title'>Product Name</p>
        <p class='field-price'>Price</p>
    </div>
</script>
<div class='action-button-holder'>
    <button class='btn' id='addproduct'>Add Product</button>
</div>
<div class='instructions'>
    <h3 style="border-bottom: solid 2px #C54808;">Instructions</h3>

    <li>Drag a product to re-arrange it.</li>
    <li>Click on a product to edit it. </li>
    <li>Click the 'X' on a product to remove it.</li>
    <li>Click the '#' on a product to hide / show it.</li>
    <li>JPEG, GIF and PNG files can all be uploaded.</li>
    <li>Any photo over 1000 x 1000 pixels will be resized.</li>
    <li>Be patient uploading. Uploading photos directly<br />
        from a digital camera can be take some time.</li>
</div>
<div style="clear:both; padding-bottom:10px;"></div>
<div class='rw-products'>
</div>
