<?php

$count == 0;
foreach($this->getProducts($page->pagename) as $product): ?>

<?php if ($product->hidden == "0"):?>
<?php if (in_array($product->display, array('half-left', 'half-right', 'full-noimage'))): ?>
  <!-- SMALL PRODUCT -->
  <?php if($count % 2 == 0){echo "<div class=\"item-l\">";} else {echo "<div class=\"item-r\">";}?>
  <div class="title"><?php echo htmlspecialchars($product->title) ?></div>
  <a name="<?php echo $product->sku ?>" id="<?php echo $product->sku ?>" class="prod_anchor"></a>
  <?php 
    if($product->display =="half-left") echo "<div class=\"smphoto\">";
	elseif($product->display =="half-right") echo "<div class=\"smphoto1\">";
	elseif($product->display =="full-noimage" or $product->display =="heading") echo "<div class=\"smphoto\" style=\"display:none;\">";
  ?> 
  <?php if($product->badge == "new"){echo "<div class=\"wrapper\"><div class=\"new_badge\"></div></div>";}?>
  <?php if($product->badge == "sale"){echo "<div class=\"wrapper\"><div class=\"sale_badge\"></div></div>";}?>
    <a href="<?php echo $product->image ?>" class="highslide" onclick="return hs.expand(this)"><img src="<?php echo $product->image ?>" class="prod_photo"></a>
  </div>
  <?php if(!empty($product->description)){echo "<div class=\"desc\">" . nl2br($product->description) . "</div>";} ?>
  <?php if(!empty($product->description2)){echo "<div class=\"desc2\">" . $product->description2 . "</div>";} ?>
  <div class="info"><?php echo $product->info ?></div>
  <div class="series"><?php echo $product->sku ?></div>
  <!--<div class="cart">
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
        <input name="image2" class="cartbutton" type="image" onMouseOver="javascript:this.src='../rw-content/templates/mack/images/add_to_cart-over.png';" onMouseOut="javascript:this.src='../rw-content/templates/mack/images/add_to_cart.png';" value="Submit" src="../rw-content/templates/mack/images/add_to_cart.png">
      </div>
    </form>
  </div>-->
</div>
<?php if($count++ % 2 <> 0){echo "<div style=\"clear:both;\"></div><hr>";} ?>
<?php else:?>
<!-- LARGE PRODUCT -->
<div class="item">
  <?php 
    if($product->display =="half-noimage") echo "<div class=\"photo\">";
	elseif($product->display == "full-left") echo "<div class=\"photo1\">";
	elseif($product->display == "full-right" or $product->disp == "heading") echo "<div class=\"smphoto\" style=\"display:none;\">";
  ?> 
  <?php if($product->itemBadge == 'new'){echo "<div class=\"wrapper\"><div class=\"new_badge\"></div></div>";}?>
  <?php if($product->itemBadge == 'sale'){echo "<div class=\"wrapper\"><div class=\"sale_badge\"></div></div>";}?>
  <a href="<?php echo $product->image ?>" class="highslide" onclick="return hs.expand(this)"><img src="<?php echo $product->image ?>" class="prod_photo"></a></div>
  <div class="title <?php if($product->display =="heading") echo "head"; ?>"><?php echo htmlspecialchars($product->title) ?></div>
  <a name="<?php echo $product->sku ?>" id="<?php echo $product->sku ?>" class="prod_anchor"></a>
  <?php if(!empty($product->description)){echo "<div class=\"desc\">" . nl2br($product->description) . "</div>";} ?>
  <?php if(!empty($product->description2)){echo "<div class=\"desc2\">" . $product->description2 . "</div>";} ?>
  <div class="info"><?php echo $product->info ?></div>
  <div class="series"><?php echo $product->sku ?></div>
  <!--<div class="cart">
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
        <input name="image2" class="cartbutton" type="image" onMouseOver="javascript:this.src='../rw-content/templates/mack/images/add_to_cart-over.png';" onMouseOut="javascript:this.src='../rw-content/templates/mack/images/add_to_cart.png';" value="Submit" src="../rw-content/templates/mack/images/add_to_cart.png">
      </div>
    </form>
  </div>-->
</div>
<div style=\"clear:both;\"></div>
<?php if($product->display !="heading") echo "<hr>"; ?>
<?php endif ?>
<!--<script type='text/javascript'>upd_prod('<?php echo addslashes($product->title) ?>','<?php echo addslashes($product->id) ?>',<?php echo $product->price ?>);</script>-->
<script type='text/javascript'>$("tr:even").css("background-color", "#d7c7b3");</script>
<script type='text/javascript'>$("th").css("background-color", "#d7c7b3");</script>
<?php endif ?>
<?php endforeach; ?>
<div style="clear:both;"></div>
