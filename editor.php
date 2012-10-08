<link rel='products' href='<?php echo $this->productsURL ?>/<?php echo $view->page->pagename ?>'>
<link rel='productsSettings' href='<?php echo $this->globalSettingsURL ?>'>
<link rel='stylesheet' href='<?php echo $this->baseURL ?>/rw-products.css'>
<link rel='all-products' href='<?php echo $this->productsURL ?>'>
<script type='text/html' id='productsEditorTemplate'>
    <div class='modal rwProducts-input' style="width:580px;">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>Add / Edit Product</h3>
        </div>
        <div class="modal-body">
            <div class='upper row'>
                <div class='productImage span2'>
                    <img src=''>
                    <form action='<?php echo $this->rapidweb->getRouteNamed('gallery-file-upload')->url; ?>' method='POST' class='file-upload btn' target='fileUploadFrame' enctype='multipart/form-data'>
                      <input type='hidden' name='pagename' value='<?php echo $view->page->pagename; ?>'>
                      <label>Upload Image</label><input type='file' name='img'><iframe id='fileUploadFrame' style="display: none;"></iframe>
                    </form>
                </div>
                <div class='majorDetails span3'>
                    <input type='text' name='title' placeholder='Product Title' style="width: 270px;"> $<input type='text' name='price' placeholder='Price' style="width: 50px; margin-left:5px;">
                    <textarea name='description' placeholder='Product Description' style="width: 360px; height: 100px;"></textarea>
                    <textarea name='description2' placeholder='Secondary Description' style="width: 360px; height: 65px;"></textarea>
                </div>
                <div class='minorDetails span7' style="line-height: 2em;">
                    <input type='text' name='info' placeholder='Product Info' style="float:left; width: 265px;">
                    <input type='text' name='sku' placeholder='Product ID / SKU' style="float:left; width: 130px; margin-left: 10px;">
                    <input type='text' name='weight' placeholder='Weight (in lb)' style="float:left; width: 50px; margin-left: 10px; margin-right: 5px;">lbs
                </div>
            </div>
            <button class='btn addOptionGroup'>Add Option Group</button><h3 style="width:100px; display: inline-block;">Options:</h3>
            <div class='productOptionGroups'>
            </div>
        </div>
        <div class="modal-footer" style="text-align:left;">
            <!--<button class='btn dump'>Debug Dump</button>-->
            <div style="float:right; margin-right: 30px;">
              <a href="#" class="btn" data-dismiss="modal">Cancel</a>
              <a href="#" class="btn save btn-primary">Save</a>
            </div>
        </div>
    </div>
</script>

<script type='text/html' id='ProductOptionGroupEditor'>
    <div class='productOptionGroup'>
        <input type="text" placeholder='Option Category Name' name='optionGroupName' style="width:196px; margin-right: 4px; margin-bottom: 5px;"><button class='btn addOption'>+</button>
	<br>
        <div class='productOptions'>
        </div>
    </div>
</script>

<script type='text/html' id='ProductOptionEditor'>
    <div class='optionEntry'>
        <input type="text" name='optionName' class='optionName' placeholder='Option Name'>$<input type="text" name='optionPrice' class='optionPrice' placeholder='+ Cost'>
    </div>
</script>

<script type='text/html' id='ProductFullView'>
    <div><h2 class='name'>Product Name</h2>
        <p class='description'>Description</p>
        <p class='description2'>Description2</p>
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
        <div class='doHide'>#</div>
        <div class='doDelete'>X</div>
        <img src='' class='image'>
        <p class='field-title'>Product Name</p>
        <p class='field-price'>Price</p>
    </div>
</script>
<div class='instructions'>
    <h3 style="border-bottom: solid 2px #C54808;">Instructions</h3>
    <div class="panel">
    <li>Drag a product to re-arrange it.</li>
    <li>Click on a product to edit it. </li>
    <li>Click the <img src='images/button_hide.png'> on a product to show / hide it.</li>
    <li>Click the <img src='images/button_cancel.png'> on a product to remove it.</li>
    </div>
    <div class="panel">
    <li>Drag the 'Insert Here' arrow to shift where new products are added.</li>
    <li>JPEG, GIF and PNG files can all be uploaded.</li>
    <li>Any photo over 1000 x 1000 pixels will be resized.</li>
    <li>Be patient uploading. Uploading photos directly<br />
        from a digital camera can be take some time.</li>
    </div>
</div>
<div class='action-button-holder panel'>
    <button class='btn btn-primary' id='addproduct'>Add Product</button>
    <button class='btn' id='global_settings'>Settings</button>
</div>
<div style="clear:both; padding-bottom:10px;"></div>
<div class='rw-products'>
    <div class='insertion-point'></div>
</div>

<div id='global_settings_modal' class='hide modal'>
    <div class='modal-header'>
        <h3>Settings</h3>
    </div>
    <div class='modal-body'>
        <label>Enable Products <input type='checkbox' name='enableProducts' value='1' <?php echo (bool)$this->getSetting('enableProducts')->value ? 'checked' : '' ?>></input></label>
    </div>
    <div class='modal-footer'>
        <button class='btn btn-primary'>Save</button>
    </div>
</div>
