<?php

class Product {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getProduct(){
        $this->db->query('SELECT id,name,price,status from product');
        $result = $this->db->resultSet();
        return $result;
    }

    public function addProduct($data){
        $this->db->query('INSERT INTO product(name, price, status) VALUES (:name, :price, :status)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':status', $data['status']);
        
        //execute 
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getProductById($id){
        $this->db->query('SELECT * FROM product WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();

        return $row;
    }

    public function updateProduct($data){
        $this->db->query('UPDATE product SET name = :name, price = :price, status = :status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':body', $data['body']);
        
        //execute 
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //delete a post
    public function deleteProduct($id){
        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}