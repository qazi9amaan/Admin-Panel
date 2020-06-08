<?php
class Orders
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
            'order_id' => 'ID',
            'product_id' => 'Product',
            'user_id' => 'User',
            'ordered_at' => 'Created at',
        ];

        return $ordering;
    }
}

?>

