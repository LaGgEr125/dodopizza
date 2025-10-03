<?php
require_once "db.php";
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'add':
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            
            $stmt = $mysqli->prepare("SELECT id, name, price, img FROM goods WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
            
            if ($product) {
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'img' => $product['img'],
                        'quantity' => $quantity
                    ];
                }
            }
            break;
            
        case 'update':
            $product_id = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
            break;
            
        case 'remove':
            $product_id = (int)$_POST['product_id'];
            unset($_SESSION['cart'][$product_id]);
            break;
            
        case 'checkout':
            if (!empty($_SESSION['cart'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                
                $stmt = $mysqli->prepare("INSERT INTO orders (total_amount) VALUES (?)");
                $stmt->bind_param("d", $total);
                $stmt->execute();
                $order_id = $mysqli->insert_id;

                $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
                foreach ($_SESSION['cart'] as $item) {
                    $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
                    $stmt->execute();
                }
                
                $_SESSION['cart'] = [];
                
                header("Location: order_success.php?order_id=" . $order_id);
                exit();
            }
            break;
    }
    
    header("Location: cart.php");
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Корзина - ДОДО ПИЦЦА</title>
</head>
<body>
    <div class="navbar-1" id="top-bar">
        <img src="img/logo.avif" class="pidor">
        <a class="nav-button" href="#">DoDo Pizza</a>
        <a class="nav-button" href="index.php">На главную</a>
        <?php if (!empty($_SESSION['cart'])): ?>
            <button class="nav-button" href="cart.php" style="position:relative;">
                <a class="bi bi-cart2" href="cart.php"></a>
                <span class="cart-indicator-dot"></span>
            </button>
        <?php else: ?>
            <button class="nav-button" href="cart.php"><a class="bi bi-cart2" href="cart.php"></a></button>
        <?php endif; ?>
    </div>

    <div class="container my-5">
        <h2>Корзина</h2>
        <hr>
        
        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Сумма</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): 
                            $item_total = $item['price'] * $item['quantity'];
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="img/<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" style="width: 50px; height: 50px; object-fit: cover;" class="me-3">
                                        <?php echo $item['name']; ?>
                                    </div>
                                </td>
                                <td><?php echo $item['price']; ?> ₽</td>
                                <td>
                                    <form method="POST" class="d-flex align-items-center" style="max-width: 150px;">
                                        <input type="hidden" name="action" value="update">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control me-2" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td><?php echo $item_total; ?> ₽</td>
                                <td>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="remove">
                                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Итого:</strong></td>
                            <td><strong><?php echo $total; ?> ₽</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-back">Продолжить покупки</a>
                <form method="POST" class="d-inline">
                    <input type="hidden" name="action" value="checkout">
                    <button type="submit" class="but">Оформить заказ</button>
                </form>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <h3>Ваша корзина пуста</h3>
                <p>Добавьте товары из меню</p>
                <a href="index.php" class="but">Перейти в меню</a>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html>