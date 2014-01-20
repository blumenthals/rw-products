<link rel='products' href='<?php echo $this->productsURL ?>/<?php echo $view->page->pagename ?>'>
<link rel='productsSettings' href='<?php echo $this->globalSettingsURL ?>'>
<link rel='stylesheet' href='<?php echo $this->baseURL ?>/rw-products.css'>
<link rel='all-products' href='<?php echo $this->productsURL ?>'>
<script type='text/html' id='productsEditorTemplate'>
    <div class='modal rwProducts-input'>
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
                      <label>Upload Image</label><input type='file' name='img'><iframe id='fileUploadFrame' name='fileUploadFrame' style='display: none;'></iframe>
                    </form>
					<br /><br /><a href='http://tablegen.nfshost.com' target="_blank" class="btn" style="display: block;">Table Generator</a>
					<br />Badge:<select style="width: 90px;" name="badge" id="badge">
					  <option value="none">None</option>
					  <option value="new">New!</option>
					  <option value="sale">Sale</option>
					</select>
                </div>
                <div class='majorDetails span6' style="width: 640px;">
                    <input type='text' name='title' placeholder='Product Title' style="width: 320px;"> $<input type='text' name='price' placeholder='Price' style="width: 50px; margin-left:5px;"> Layout:<select style="width: 190px;" name="display" id="disp">
					  <option value="half-left">Half - Image Left</option>
					  <option value="half-right">Half - Image Right</option>
					  <option value="half-noimage">Half - No Image</option>
					  <option value="full-left">Full - Image Left</option>
					  <option value="full-right">Full - Image Right</option>
					  <option value="full-noimage">Full - No Image</option>
					  <option value="heading">Heading</option>
					</select>
                    <textarea name='description' placeholder='Product Description' style="width: 660px; height: 140px;"></textarea>
                    <textarea name='description2' placeholder='Secondary Description' style="width: 660px; height: 105px;"></textarea>
                </div>
                <div class='minorDetails span7' style="line-height: 2em; width: 670px;">
                    <input type='text' name='info' placeholder='Product Info' style="float:left; width: 445px;">
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
        <p>Display Type <span class='display'>--</span></p>
        <p>New Product <span class='badge'>--</span></p>
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
    <span>
	  <input type='checkbox' name='enableProducts' class='enable_products' value='1' <?php echo ((int)$this->getSetting('enableProducts')->value) ? 'checked="checked"' : '' ?>></input>
	  <label for="xxx"></label>
	</span>
    </div>
    <div class='modal-footer'>
        <button class='btn btn-primary'>Save</button>
    </div>
</div>
