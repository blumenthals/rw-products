<?php $count == 0; ?>
<?php foreach($this->getProducts($page->pagename) as $product): ?>
  <?php if ($product->hidden) continue; ?>
  <?php if (in_array($product->layout, array('half-left', 'half-right', 'half-noimage'))): ?>
    <!-- SMALL PRODUCT -->
    <div class="<?php echo $count % 2 ? "item-r" : "item-l" ?>">
    <div class="title"><?php echo htmlspecialchars($product->title) ?></div>
    <a name="<?php echo $product->sku ?>" id="<?php echo $product->sku ?>" class="prod_anchor"></a>
    <?php if ($product->layout != 'half-noimage'): ?>
      <div class='<?php echo ($product->layout == "half-left" ? "smphoto" : "smphoto1") ?>'>
        <?php if($product->badge == "new"): ?>
          <div class="wrapper"><div class="new_badge"></div></div>
        <?php endif ?>
        <?php if($product->badge == "sale"): ?>
          <div class="wrapper"><div class="sale_badge"></div></div>
        <?php endif ?>
        <a href="<?php echo $product->image ?>" class="highslide" onclick="return hs.expand(this)"><img src="<?php echo $product->image ?>" class="prod_photo"></a>
      </div>
    <?php endif ?>
    <?php if(!empty($product->description)): ?>
      <div class="desc"><?php echo nl2br($product->description) ?></div>
    <?php endif ?>
    <?php if(!empty($product->description2)): ?>
      <div class="desc2"><?php echo $product->description2 ?></div>
    <?php endif ?>
    <div class="info"><?php echo $product->info ?></div>
    <div class="series"><?php echo $product->sku ?></div>
    <!--
    <div class="cart">
      <form name="myform" id="cart<?php echo $product->id ?>" target="form_popup" onsubmit="return Popup();" action="http://ww6.aitsafe.com/cf/add.cfm" method="post">
        <div class="options">
          <?php if($product->options): ?>
            <?php foreach ($product->options as $category): ?>
              <div class="category"><?php echo $category['name'] ?>:</div>
              <select class="cartsel" name="productoption" onchange="upd_prod('<?php echo $product->title ?>','<?php echo $product->id ?>', <?php echo $product->price ?>)">
                <?php foreach ($category['options'] as $option): ?>
                  <option value="<?php echo $category['name'].":".$option['name'].":".$option['price'] ?>">
                    <?php echo $option['name'] ?> 
                    <?php if ($option->price > 0): ?>
                      (+ $<?php echo $option['price'] ?>)
                    <?php endif ?>
                  </option>
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
    </div>
    -->
  </div>
  <?php if($count++ % 2 == 1): ?>
    <div style="clear:both;"></div><hr>
  <?php endif ?>
<?php else: ?>
  <!-- LARGE PRODUCT -->
  <div class="item <?php echo $product->layout ?>">
    <?php if ($product->layout != 'heading' and $product->layout != 'full-noimage'): ?>
      <div class='<?php echo $product->layout == "full-left" ? "photo" : "photo1" ?>'>
        <?php if($product->badge == "new"): ?>
          <div class="wrapper"><div class="new_badge"></div></div>
        <?php endif ?>
        <?php if($product->badge == "sale"): ?>
          <div class="wrapper"><div class="sale_badge"></div></div>
        <?php endif ?>
        <a href="<?php echo $product->image ?>" class="highslide" onclick="return hs.expand(this)"><img src="<?php echo $product->image ?>" class="prod_photo"></a>
      </div>
    <?php endif ?>
    <div class="title <?php if($product->layout =="heading") echo "head"; ?>"><?php echo htmlspecialchars($product->title) ?></div>
    <a name="<?php echo $product->sku ?>" id="<?php echo $product->sku ?>" class="prod_anchor"></a>
    <?php if(!empty($product->description)): ?>
      <div class="desc"><?php echo nl2br($product->description) ?></div>
    <?php endif ?>
    <?php if(!empty($product->description2)): ?>
      <div class="desc2"><?php echo $product->description2 ?></div>
    <?php endif ?>
    <div class="info"><?php echo $product->info ?></div>
    <div class="series"><?php echo $product->sku ?></div>
    <!--
      <div class="cart">
        <form name="myform" id="cart<?php echo $product->id ?>" target="form_popup" onsubmit="return Popup();" action="http://ww6.aitsafe.com/cf/add.cfm" method="post">
          <div class="options">
            <?php if($product->options): ?>
              <?php foreach ($product->options as $category): ?>
                <div class="category"><?php echo $category['name'] ?>:</div>
                <select class="cartsel" name="productoption" onchange="upd_prod('<?php echo $product->title ?>','<?php echo $product->id ?>', <?php echo $product->price ?>)">
                  <?php foreach ($category['options'] as $option): ?>
                    <option value="<?php echo $category['name'].":".$option['name'].":".$option['price'] ?>">
                      <?php echo $option['name'] ?> 
                      <?php if ($option->price > 0): ?>
                        (+ $<?php echo $option['price'] ?>)
                      <?php endif ?>
                    </option>
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
      </div>
      -->
    </div>
    <div style="clear:both;"></div>
    <?php if($product->layout != "heading"): ?>
      <hr>
    <?php endif ?>
  <?php endif ?>
  <!--<script type='text/javascript'>upd_prod('<?php echo addslashes($product->title) ?>','<?php echo addslashes($product->id) ?>',<?php echo $product->price ?>);</script>-->
  <script>
    $("tr:even").css("background-color", "#d7c7b3");
    $("th").css("background-color", "#d7c7b3");
  </script>
<?php endforeach; ?>

<div style="clear:both;"></div>
