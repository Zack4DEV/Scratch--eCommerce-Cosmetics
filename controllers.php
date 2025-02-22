<?php
function get_db_connection() {
    try {
        $pdo = new PDO("sqlite: database/ecommerce.db");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database Connection Error: " . $e->getMessage());
        return false;
    }
}

function safe_query($query, $params = []) {
    $pdo = get_db_connection();
    if (!$pdo) return [];

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Query Error: " . $e->getMessage());
        return [];
    }
}

function index()
{
    $products = safe_query("SELECT * FROM products");
    require_once 'front/index.php';
}

function products($id)
{
    $products = safe_query("SELECT * FROM products WHERE category_id = ?", [$id]);
    require_once 'front/products.php';
}

function product($id)
{
    $product = safe_query("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
    $product = !empty($product) ? $product[0] : null;
    require_once 'front/product.php';
}

function login()
{
    require_once 'front/login.php';
}

function register()
{
    if (!empty($_POST)) {
        $data = $_POST;
        $data['admin'] = 0;
        try {
            $pdo = get_db_connection();
            if ($pdo) {
                $stmt = $pdo->prepare("INSERT INTO user (email, password, admin) VALUES (?, ?, ?)");
                $stmt->execute([$data['email'], password_hash($data['password'], PASSWORD_DEFAULT), $data['admin']]);
                header('Location: /index.php');
                exit();
            }
        } catch (PDOException $e) {
            error_log("Registration Error: " . $e->getMessage());
            require_once 'front/error.php';
            return;
        }
    }
    require_once 'front/register.php';
}

function panier()
{
    require_once 'front/panier.php';
}

function admin_index()
{
    require_once 'admin/index.php';
}

function admin_admins()
{
    $user = safe_query("SELECT * FROM user WHERE admin = 1");
    require_once 'admin/admins.php';
}

function admin_categories()
{
    $categories = safe_query("SELECT * FROM categories");
    require_once 'admin/categories.plhp';
}

function admin_products()
{
    $products = safe_query("SELECT * FROM products");
    require_once 'admin/products.php';
}

function admin_user()
{
    $user = safe_query("SELECT * FROM user WHERE admin = 0");
    require_once 'admin/user.php';
}

function admin_product_add() 
{
    if (!empty($_POST)) {
        try {
            $pdo = get_db_connection();
            if ($pdo) {
                $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id) VALUES (?, ?, ?, ?)");
                $stmt->execute([$_POST['name'], $_POST['description'], $_POST['price'], $_POST['category_id']]);
                // Handle file upload here if needed
                header('Location: /index.php/admin/products');
                exit();
            }
        } catch (PDOException $e) {
            error_log("Product Add Error: " . $e->getMessage());
            require_once 'admin/error.php';
            return;
        }
    }
    $categories = safe_query("SELECT * FROM categories");
    require_once 'admin/product_add.php';
}

function admin_category_add()
{
    if (!empty($_POST)) {
        try {
            $pdo = get_db_connection();
            if ($pdo) {
                $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
                $stmt->execute([$_POST['name']]);
                header('Location: /index.php/admin/categories');
                exit();
            }
        } catch (PDOException $e) {
            error_log("Category Add Error: " . $e->getMessage());
            require_once 'admin/error.php';
            return;
        }
    }
    require_once 'admin/category_add.php';
}

function admin_category_del($id) 
{
    safe_query("DELETE FROM categories WHERE id = ?", [$id]);
    header('Location: /index.php/admin/categories');
    exit();
}

function admin_remove_product($id) 
{
    safe_query("DELETE FROM products WHERE id = ?", [$id]);
    header('Location: /index.php/admin/products');
    exit();
}

function admin_remove_user($id) 
{
    safe_query("DELETE FROM user WHERE id = ?", [$id]);
    header('Location: /index.php/admin');
    exit();
}

function try_login() 
{
    try {
        $pdo = get_db_connection();
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
            $stmt->execute([$_POST['email']]);
            $user = $stmt->fetch();

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION["logged"] = true;
                $_SESSION["id"] = $user['id'];
                $_SESSION["email"] = $user['email'];

                if ($user['admin'] == 1) {
                    header('Location: /index.php/admin');
                } else {
                    header('Location: /index.php');
                }
                exit();
            }
        }
    } catch (PDOException $e) {
        error_log("Login Error: " . $e->getMessage());
    }
    require_once 'front/error.php';
}

function admin_categories_import() 
{
    if (!empty($_FILES)) {
        try {
            $file = $_FILES['file']['tmp_name'];
            $handle = fopen($file, "r");
            $pdo = get_db_connection();

            if ($pdo) {
                $pdo->beginTransaction();
                $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");

                $i = 0;
                while (($data = fgetcsv($handle)) !== FALSE) {
                    if ($i > 0) {
                        $stmt->execute([$data[0]]);
                    }
                    $i++;
                }

                $pdo->commit();
                fclose($handle);
                header('Location: /index.php/admin');
                exit();
            }
        } catch (PDOException $e) {
            if ($pdo) $pdo->rollBack();
            error_log("Import Error: " . $e->getMessage());
            require_once 'admin/error.php';
            return;
        }
    }
    require_once 'admin/import.php';
}

// Rest of the functions remain the same as they don't interact with the database directly
function add_panier($id) {
    $product = safe_query("SELECT * FROM products WHERE id = ? LIMIT 1", [$id]);
    if (!empty($product)) {
        $product = $product[0];
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
            $_SESSION['cart'][$id]['quantity'] = 1;
            $_SESSION['cart'][$id]['name'] = $product['name'];
        } else {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity']++;
            } else {
                $_SESSION['cart'][$id]['quantity'] = 1;
                $_SESSION['cart'][$id]['name'] = $product['name'];
            }
        }
    }
    header('Location: /index.php/panier');
    exit();
}

function del_panier($id) {
    if (!empty($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] = 0;
    }
    header('Location: /index.php/panier');
    exit();
}

function pay() {
    if(!empty($_GET['paymentID']) && !empty($_GET['token']) && !empty($_GET['payerID']) && !empty($_GET['pid'])) {
        header("Location: /index.php/thanks");
    } else {
        header("Location: /index.php");
    }
}

function thanks() {
    require_once 'front/thanks.php';
}
?>