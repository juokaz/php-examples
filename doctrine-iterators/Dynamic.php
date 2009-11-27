<?php

/**
 * Split Doctrine query into chunks dynamicaly by getting all the records up to
 * the limit, but only those which haven't been retrieved yet.
 *
 * Difference from standart chunk iterator - this iterator allows updating/deleting
 * returned results and still iterate over all of them
 */
class App_Model_Iterator_Dynamic extends App_Model_Iterator_Chunk
{
    /**
     * Already retrieved id's
     *
     * @var array
     */
    protected $_ids = array();

    /**
     * Primary field
     *
     * @var int
     */
    protected $_field = 'id';

    /**
     * Get collection iterator
     *
     * @return Iterator
     */
    protected function getIterator()
    {
        $query = clone $this->q;

        $this->_collection = $query->andWhereNotIn($this->_field, $this->_ids)->execute();

        foreach ($this->_collection->getPrimaryKeys() as $id)
        {
            $this->_ids[] = $id;
        }

        return $this->_collection->getIterator();
    }
}