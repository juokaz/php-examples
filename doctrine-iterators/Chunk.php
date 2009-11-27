<?php

/**
 * Split Doctrine query into chunks
 */
class App_Model_Iterator_Chunk implements Iterator {

    /**
     * Query
     *
     * @var Doctrine_Query
     */
    protected $q;

    /**
     * Offset
     *
     * @var int
     */
    protected $offset;

    /**
     * Limit
     *
     * @var int
     */
    protected $limit;

    /**
     * Current record
     *
     * @var Doctrine_Record
     */
    protected $current = false;

    /**
     * Results iterator
     *
     * @var Iterator
     */
    protected $result = null;


    /**
     * Data collection
     *
     * @var Doctrine_Collection
     */
    protected $_collection = null;

    /**
     * Create new iterator, uses $limit to run multiple queries in chunks
     *
     * @param Doctrine_Query $q
     * @param int $limit
     */
    public function __construct(Doctrine_Query $q, $limit)
    {
        $this->q    = $q->limit($limit);
        $this->offset = 0;
        $this->limit  = $limit;
    }

    /**
     * Get query
     *
     * @return Doctrine_Query
     */
    public function getQuery()
    {
        return $this->q;
    }

    /**
     * Get collection iterator
     *
     * @return Iterator
     */
    protected function getIterator()
    {
        $query = clone $this->q;

        $this->_collection = $query->offset($this->offset)->execute();

        return $this->_collection->getIterator();
    }

    /**
     * Get current item
     *
     * @return Doctrine_Record|array
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * Move to the next item
     */
    public function next()
    {
        if ($this->result)
        {
            $this->current = $this->result->current();
            $this->result->next();
        }

        if (!$this->current)
        {
            // if it's not a first iteration
            if (isset($this->_collection))
            {
                $this->_collection->free(true);
            }
            
            $this->result = $this->getIterator();

            $this->current = $this->result->current();
            $this->result->next();

            $this->offset += $this->limit;
        }
    }

    /**
     * Item key
     *
     * @return int
     */
    public function key()
    {
        return null;
    }

    /**
     * Is valid (are there more items)
     *
     * @return boolean
     */
    public function valid()
    {
        if (!$this->current) {
            $this->next();
        }
        return (bool)$this->current;
    }

    /**
     * Rewind iterator
     */
    public function rewind()
    {
        $this->offset = 0;
    }
}