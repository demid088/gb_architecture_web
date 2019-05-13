<?php

declare (strict_types = 1);

namespace Mapper;

use Model\Entity\Product;

class ProductMapper
{
  /**
   * @var \PDO
   */
  protected $db;

  public function __construct(\PDO $db)
  {
    $this->db = $db;
  }

  public function saveProduct(Product &$product)
  {
    if ($product->getId()) {
      $sql = "UPDATE product SET name = :name, price = :price WHERE id = :id";
      $statement = $this->db->prepare($sql);
      $statement->bindParam(":id", $product->getId());
      $statement->bindParam(":name", $product->getName());
      $statement->bindParam(':price', $product->getPrice());
      $statement->execute();
    } else {
      $sql = "INSERT INTO product (name, price) VALUES (:name, :price)";
      $statement = $this->db->prepare($sql);
      $statement->bindParam(":name", $product->getName());
      $statement->bindParam(':price', $product->getPrice());
      $statement->execute();
      $lastId = $this->db->lastInsertId();
      $product->setId($lastId);
    }
  }

  public function loadProductById(int $id): Product
  {
    $sql = "SELECT * FROM product WHERE id = :id";
    $statement = $this->db->prepare($sql);
    $statement->bindParam(":id", $id);
    $statement->execute();
    $product = $statement->fetchObject(Product::class);
    return $product;
  }

  public function loadProductAll(): array
  {
    $sql = "SELECT * FROM product";
    $statement = $this->db->prepare($sql);
    $statement->execute();
    $product = $statement->fetchAll(\PDO::FETCH_CLASS, Product::class);
    return $product;
  }
}
