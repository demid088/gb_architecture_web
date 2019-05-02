<?php

namespace Model\Repository;

class IdentityMap
{
  private $identityMap = [];

  public function addRecord($obj)
  {
    $key = $this->getKey(get_class($obj), $obj->getId());

    $this->identityMap[$key] = $obj;
  }

  public function getRecord(string $classname, int $id)
  {
    $key = $this->getKey($classname, $id);

    if (isset($this->identityMap[$key])) {
      return $this->identityMap[$key];
    }
    
    // здесь получаем запись из БД, т.к. объект не был найден в массиве (кеше)
  }

  private function getKey(string $classname, int $id)
  {
    return sprintf('%s.%d', $classname, $id);
  }
}
