<?php
class Categories
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
            'category_base' => 'Category Type',
            'created_at' => 'Created at',
        ];

        return $ordering;
    }
}
?>

