<?php

/**
 * @author  ryan <cumt.xiaochi@gmail.com>
 */

class SesState
{
    public function addProduct(Product $prd)
    {
        $products = self::chosenProducts();

        $id = $prd->id;

        if (!isset($products[$id])) {
            $products[$id] = 1;
        } else {
            $products[$id] ++;
        }
        
        $_SESSION['se_product'] = json_encode($products);
    }

    public function chosenProducts()
    {
        if (!isset($_SESSION['se_product'])) {
            return array();
        } else {
            return json_decode($_SESSION['se_product'], true);
        }
    }

    public function clearProduct()
    {
        if (isset($_SESSION['se_product']))
            unset($_SESSION['se_product']);
    }
}
