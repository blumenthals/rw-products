<?php foreach($this->getProducts($page->pagename) as $product): ?>
    <div class='product'>
        <h2><?php echo $product->title ?></h2>
        <img src='<?php echo $product->thumbnail ?>'>
        <p><?php echo $product->description ?></p>
        <p>Price $<?php echo $product->price ?></p>
    </div>
<?php endforeach; ?>
