<?php
namespace Entry\Model;

use Zend\Db\TableGateway\TableGateway;

class EntryTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getEntry($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveEntry(Entry $entry)
    {
        $data = array(
            'url' => $entry->url,
            
        );

        $id = (int)$entry->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getEntry($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteEntry($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}