<?php
class Associate
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
            'name' => 'Associate Name',
            'bussiness_name' => 'Bussiness Name',
            'created_at' => 'Created at',
        ];

        return $ordering;
    }
}
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
            'product_owner' => 'Owner',
            'product_quality' => 'Product Quality',
            'created_at' => 'Created at',
        ];

        return $ordering;
    }
}
?>

