<?php
    include_once "config.php";

    function upload_file($file) {
        $uploadDir = __DIR__ . '/uploads/';
        $uploadFilename = $uploadDir . basename($file['file']['name']);

        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilename);

        return basename($file['file']['name']);
    }
    function get_products_by_category($id) {
        $connexion = get_db_connection();
        $query = "SELECT * FROM product WHERE category=" . $id;
        $stmt = $connexion->query($query);
        $stmt->execute();		

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products; 
    }
    function get_products_by_id($id) {
        $connexion = get_db_connection();
        $query = "SELECT * FROM product WHERE id=" . $id;
        $stmt = $connexion->query($query);
        $stmt->execute();		

        $products = $stmt->fetch(PDO::FETCH_ASSOC);

        return $products; 
    }
    function get_products() {
        $connexion = get_db_connection();
        $query = "SELECT * FROM product";
        $stmt = $connexion->query($query);
        $stmt->execute();		

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products; 
    }
    function set_product($data, $files) {
        $connexion = get_db_connection();
        $query = "INSERT INTO product SET name=:name, description=:description, price=:price, category=:category, filename=:filename";

        $stmt = $connexion->prepare($query);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":category", $data['category']);

        $filename = upload_file($files);
        $stmt->bindParam(":filename", $filename);

        $stmt->execute();
    }
    function get_categories() {
        $connexion = get_db_connection();
        $query = "SELECT * FROM category";
        $stmt = $connexion->query($query);
        $stmt->execute();		

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $categories; 
    }
    function set_category($data) {
        $connexion = get_db_connection();
        $query = "INSERT INTO category SET name=:name";

        $stmt = $connexion->prepare($query);
        $stmt->bindParam(":name", $data['name']);
        $stmt->execute();
    }
    function remove_category($id) {
        $connexion = get_db_connection();
        $query = "DELETE FROM category WHERE id=" . $id;

        $stmt = $connexion->query($query);
        $stmt->execute();
    }
    function remove_product($id) {
        $connexion = get_db_connection();
        $query = "DELETE FROM product WHERE id=" . $id;

        $stmt = $connexion->query($query);
        $stmt->execute();
    }
    function get_users($isAdmin = 0) {
        $connexion = get_db_connection();
        $query = "SELECT * FROM user WHERE admin=" . $isAdmin;
        $stmt = $connexion->query($query);
        $stmt->execute();		

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users; 
    }
    function set_user($data) {
    $connexion = get_db_connection();
    $query = "INSERT INTO user VALUES(email,password,admin)";

    $stmt = $connexion->prepare($query);
    $email = $data['email'];
    $password = md5($data['password']);
    $admin = (isset($data['admin'])) ? 1 : 0;
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":admin", $admin);
    $stmt->execute();
}

    function remove_user($id) {
        $connexion = get_db_connection();
        $query = "DELETE FROM user WHERE id=" . $id;

        $stmt = $connexion->query($query);
        $stmt->execute();
    }
    function find_user_by_email_and_password($data){
        $connexion = get_db_connection();
        $query = "SELECT * FROM user WHERE email='" . $data['email'] ."'";
        $stmt = $connexion->query($query);
        $stmt->execute();		

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!empty($user) && ($user['password'] == md5($data['password']))) {
            return $user;
        } else {
            return null;
        }
    }
?>