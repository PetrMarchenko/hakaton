<?php
namespace Lib\Model\Table;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;


class BasicTable
{
    protected $tableGateway;

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getById($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        return $row;
    }

    public function isUnique($param, $id = null)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($param, $id) {
            $select->where($param);

            if($id) {
                $select->where(array("id !=".$id));
            }

            return $select;
        });
        return ($resultSet->count()) ? false : true;
    }

    public function getByToArray($data, $order=null)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($data, $order){
            $select->where($data);
            if ($order) {
                $select->order($order);
            }
            return $select;
        });

        return $resultSet;
    }

    public function getByIdToArray($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        $obj[]= $row;
        return $obj;
    }

    public function getBy($array)
    {
        $rowset = $this->tableGateway->select($array);
        $row = $rowset->current();
        return $row;
    }

    public function save($object, $data = array())
    {
        if ($data) {
            $object = $this->setData($object, $data);
        }

        $data = $this->getData($object);

        $data = $this->preDate($data);

        if ($object->id) {
            unset($data['id']);
            return $this->tableGateway->update($data, array('id'=>$object->id));
        } else {
            return $this->tableGateway->insert($data);
        }
    }

    public function preDate($data) {
        return $data;
    }

    public function setData($object, $data)
    {
        foreach ($object->map as $key =>$value) {
            (array_key_exists($value,$data)) ? $object->$key = $data[$value] : false;
        }
        return $object;
    }

    public function getData($object) {

        $data = array();

        foreach ($object->map as $key => $value) {
            $data[$value] = $object->$key;
        }
        return $data;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function All($order)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($order) {
            $select->order($order);
            return $select;
        });

        return $resultSet;
    }

    public function getMax($pole)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($pole) {
            $select->order($pole.' DESC');
            $select->limit(1);
            return $select;
        });

        $row = $resultSet->current();
        return $row;
    }

    public function getMin($pole)
    {
        $resultSet = $this->tableGateway->select(function (Select $select) use ($pole) {
            $select->order($pole.' ASC');
            $select->limit(1);
            return $select;
        });

        $row = $resultSet->current();
        return $row;
    }


    public function deleteWhere($where)
    {
        return $this->tableGateway->delete($where);
    }

    public function delete($id)
    {
        $where = array('id' => $id);
        return $this->tableGateway->delete($where);
    }
}