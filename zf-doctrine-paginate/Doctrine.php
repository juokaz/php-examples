<?php

class App_Paginator_Doctrine extends Zend_Paginator
{
    /**
     * Get new doctrine query paginator
     *
     * @param Doctrine_Query $query
     * @param int $limit
     * @param int $page
     */
    public function __construct(Doctrine_Query $query, $page = 1, $limit = 10)
    {
        parent::__construct(new App_Paginator_Adapter_DoctrineQuery($query));

        $this->setItemCountPerPage($limit);
        $this->setCurrentPageNumber($page);
    }
}