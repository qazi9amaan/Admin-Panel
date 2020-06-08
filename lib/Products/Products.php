<?php
class Products
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'product_name' => 'Product Name',
             'product_category' => 'Category',
            'product_price' => 'Product Price',
            'product_quality' => 'Product Quality',
            'created_at' => 'Created at',
        ];

        return $ordering;
    }
}
?>

