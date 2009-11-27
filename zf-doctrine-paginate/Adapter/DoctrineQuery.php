<?php

class App_Paginator_Adapter_DoctrineQuery implements Zend_Paginator_Adapter_Interface
{
    /**
     * @var Doctrine_Query
     */
    protected $_query;

    /**
     * @var int
     */
    protected $_rowCount;

    public function __construct(Doctrine_Query $query)
    {
        $this->_query = $query;
    }

    /**
     * Get items
     *
     * @param int $offset
     * @param int $itemsPerPage
     * @return Doctrine_Collection
     */
    public function getItems($offset, $itemsPerPage)
    {
        return $this->_query
            ->limit($itemsPerPage)
            ->offset($offset)
            ->execute();
    }

    /**
     * Count results
     *
     * @return int
     */
    public function count()
    {
        if ($this->_rowCount === null)
        {
            $this->_rowCount = $this->_query->count();
        }

        return $this->_rowCount;
    }
}