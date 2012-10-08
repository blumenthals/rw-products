<?php foreach($this->getProducts($page->pagename, array('hideHidden' => true)) as $product): ?>
<!--<?php echo json_encode($product); ?>-->
<?php if($product->hidden == "0"): ?>
<div class="title"><?php echo $product->title ?></div>
<a name="<?php echo $product->sku ?>" id="<?php echo $product->sku ?>"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="vertical-align:top;"><div class="photo"><a href="<?php echo $product->image ?>" class="highslide" onclick="return hs.expand(this)"><img src="<?php echo $product->thumbnail175 ?>" class="prod_photo" width="175" height="175"></a></div></td>
    <td style="vertical-align:top;"><div class="desc"><?php echo $product->description ?></div>
      <div class="desc2"><?php echo $product->description2 ?></div></td>
    <td class="divider"></td>
    <td style="vertical-align:top;"><div class="cart">
        <form name="myform" id="cart<?php echo $product->id ?>" target="form_popup" onsubmit="return Popup();" action="http://ww6.aitsafe.com/cf/add.cfm" method="post">
          <div class="options">
		  <?php if($product->options): ?>
		    <?php foreach ($product->options as $category): ?>
		      <div class="category"><?php echo $category['name'] ?>:</div>
		      <select class="cartsel" name="productoption" onchange="upd_prod('<?php echo $product->title ?>','<?php echo $product->id ?>', <?php echo $product->price ?>)">
		      <?php foreach ($category['options'] as $option): ?>
		        <?php if($option['price'] != 0) 
	    	      echo("<option value=\"".$category['name'].":".$option['name'].":".$option['price']."\">".$option['name']." (+ \$".$option['price'].")");
	    	      else echo("<option value=\"".$category['name'].":".$option['name'].":".$option['price']."\">".$option['name']);
	    	      echo("</option>");
	    	    ?>
	    	  <?php endforeach ?>
	  	      </select>
		    <?php endforeach ?>
		  <?php endif ?>
          </div>
          <div class="prod_info"><?php echo $product->info ?></div>
          <div class="price" id="price<?php echo $product->id ?>">$<?php echo $product->price ?></div>
          <input type="hidden" name="userid" value="88151914">
          <div class="addtocart">
            <input type="hidden" name="thumb" value="<?php echo substr($product->thumbnail75,1) ?>">
            <input type="hidden" name="units" value="<?php echo $product->weight ?>">
            <input type="hidden" name="productpr" id="product<?php echo $product->id ?>" value="">
            <input type='submit' class='cartbutton' value='Add to Cart'>
          </div>
        </form>
      </div></td>
  </tr>
</table>
<hr />
<script type='text/javascript'>upd_prod('<?php echo $product->title ?>','<?php echo $product->id ?>',<?php echo $product->price ?>);</script>
<?php endif ?>
<?php endforeach; ?>
