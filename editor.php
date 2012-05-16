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
                <input type='text' placeholder='Product Title'>
                <textarea placeholder='Product Description'></textarea>
                <textarea placeholder='Secondary Description'></textarea>
            </div>
            <div class='minorDetails span2'>
                <input type='text' placeholder='Product Info'>
                <input type='text' placeholder='Product ID / SKU'>
                <input type='text' placeholder='Price'>
                <input type='text' placeholder='Weight (in lb)'>
            </div>
        </div>
        <div class='productOptions'>
        </div>
    </div>
    <div class="modal-footer">
        <button class='btn addOption'>Add Option</button>
        <button class='btn uploadProductImage'>Upload Product Image</button>
        <a href="#" class="btn" data-dismiss="modal">Cancel</a>
        <a href="#" class="btn btn-primary">Save</a>
    </div>
</div>

<script type='text/html' id='optionTemplate'>
    <div class='productOption'>
        <input placeholder='Option Category Name'><br>
        <?php for ($i = 0; $i < 4; $i++): ?>
            <div class='optionEntry'>
                <input name='optionName[]' class='optionName' placeholder='Option Name'><input name='optionPrice[]' class='optionPrice' placeholder='Price'>
            </div>
        <?php endfor ?>
    </div>
</script>
<button class='btn' id='addproduct'>Add Product</button>
<div id='status'>Valid</div>
<textarea name='products'>Loading, please wait</textarea>
