<?php 

class Products extends RWPlugin {
    private $productsURL;
    private $dbc;

    public function __construct($rapidweb) {
        parent::__construct($rapidweb);
        $rapidweb->registerPagetype('products', $this);
        $this->dbc = $rapidweb->dbc;
        $this->productsURL = $rapidweb->registerResourceHandler('products', '!products/(?<product_group>[^/]+)(?:/(?<id>[0-9]+))?!', array($this, 'productsResource'));
    }

    private function getProducts($group) {
        $productQ = $this->dbc->prepare("SELECT * FROM products WHERE `group` = :group");
        $productQ->execute(array('group' => $group));
        $result = $productQ->fetchAll();
        
        $groupQ = $this->dbc->prepare("SELECT * FROM product_option_groups WHERE `product_id` = :id");
        $optionQ = $this->dbc->prepare("SELECT * FROM product_options WHERE `product_group_id` = :id");

        $results = array();
        foreach($result as $res) {
            unset($res['group']);
            $groupQ->execute(array('id' => $res['id']));
            $res['options'] = $groupQ->fetchAll();
            foreach ($res['options'] as &$optGroup) {
                $optionQ->execute(array('id' => $optGroup['id']));
                $optGroup['options'] = $optionQ->fetchAll();
            }

            $results[] = new ArrayObject($res, ArrayObject::ARRAY_AS_PROPS);
        }

        return $results;
    }

    public function productsResource($request, $response) {
        if ($request->method == 'GET') {
            $response->setHeader('Content-Type', 'application/json');
            $result = $this->getProducts($request['product_group']);

            $response->body = json_encode($result);

        } elseif ($request->method == 'POST') {
            $sth = $this->dbc->prepare("INSERT INTO products (title, description, `group`, info, sku, price, weight, image, thumbnail) VALUES (:title, :description, :group, :info, :sku, :price, :weight, :image, :thumbnail)");
            $sth->execute(array(
                ':group' => $request['product_group'],
                ':title' => $request->content->title,
                ':description' => $request->content->description,
                ':info' => $request->content->info,
                ':sku' => $request->content->sku,
                ':price' => $request->content->price,
                ':weight' => $request->content->weight,
                ':image' => $request->content->image,
                ':thumbnail' => $request->content->thumbnail
            ));

            $id = $sth->lastInsertId();

            foreach ($request->content->options as $option) {
                $sth = $this->dbc->prepare("INSERT INTO product_options (name, product_id, option, price) VALUES (:name, :product_id, :option, :price)");
                $sth->execute(array(
                    ':product_id' => $id,
                    ':name' => $option->name,
                    ':option' => $option->option,
                    ':price' => $option->price
                ));
            }

        } elseif ($request->method == 'PUT') {
            $this->dbc->beginTransaction();
            $sth = $this->dbc->prepare("UPDATE products SET title = :title, description = :description, `group` = :group, info = :info, sku = :sku, price = :price, weight = :weight, image = :image, thumbnail = :thumbnail WHERE id = :id");
            $sth->execute(array(
                ':id' => $request['id'],
                ':group' => $request['product_group'],
                ':title' => $request->content->title,
                ':description' => $request->content->description,
                ':info' => $request->content->info,
                ':sku' => $request->content->sku,
                ':price' => $request->content->price,
                ':weight' => $request->content->weight,
                ':image' => $request->content->image,
                ':thumbnail' => $request->content->thumbnail
            ));

            $sth = $this->dbc->prepare("DELETE FROM product_options WHERE product_group_id IN (SELECT id FROM product_option_groups WHERE product_id = :id)");
            $sth->execute(array(':id' => $request['id']));

            $sth = $this->dbc->prepare("DELETE FROM product_option_groups WHERE product_id = :id");
            $sth->execute(array(':id' => $request['id']));

            foreach ($request->content->options as $option_group) {
                if (!$option_group->name) continue;
                $sth1 = $this->dbc->prepare("INSERT INTO product_option_groups (product_id, name) VALUES (:product_id, :name)");
                $sth1->execute(array(
                    ':product_id' => $request['id'],
                    ':name' => $option_group->name
                ));

                $sth = $this->dbc->prepare("SELECT LAST_INSERT_ID() AS product_group_id");
                $sth->execute();
                $temp = $sth->fetch();
                $product_group_id = $temp['product_group_id'];
                foreach ($option_group->options as $option) {
                    if (!$option->name) continue;
                    $sth2 = $this->dbc->prepare("INSERT INTO product_options (name, product_group_id, price) VALUES (:name, :product_group_id, :price)");
                    $sth2->execute(array(
                        ':product_group_id' => $product_group_id,
                        ':name' => $option->name,
                        ':price' => $option->price
                    ));
                }
            }
            $this->dbc->commit();

        } else {
            throw new Exception("Unknown request method {$request->method}");
        }
        return $response;
    }

    public function do_editor_head() {
        // needs underscore too
        $this->loadJavascript('underscore-min.js');
        $this->loadJavascript('bootstrap/js/bootstrap-modal.js');
        $this->loadJavascript('backbone-min.js');
        $this->loadJavascript('backbone-bindings.js');
        $this->loadJavascript('editor.js');
    }

    public function getPageTypeName() {
        return 'Products';
    }

    public function the_editor_content($view) {
        include __DIR__.'/editor.php';
    }

    public function do_head() {
    }

    public function the_content($page) {
        echo "<h1>Products Go here</h1>";
        echo "Not done yet";
        return;
        foreach($page->plugins->products->products as $product) {
            $taxable = $product->taxable ? 'Y' : 'N';
            if($product->imageURL) {
                $img = "<p><img src='{$product->imageURL}'></p>";
            }
            print("<div id='{$product->sku}'><h2>{$product->name}</h2>
                <p>{$product->description}</p>
                $img
                <p>Price {$product->price}</p>
                <p>Weight {$product->weight}</p>
                <p>Taxable {$taxable}</p>");
            if(!empty($product->options)) {
                print("<h3>Options</h3>");
                foreach($product->options as $option) {
                    print("<p>{$option->name}: Add {$option->price}</p>");
                }
            }
            print("</div>");
        }
    }
}

$this->registerPlugin('Products');
