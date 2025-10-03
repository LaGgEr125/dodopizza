<?php
require_once "db.php";

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = (int)$_GET['order_id'];

$stmt = $mysqli->prepare("
    SELECT o.*, oi.product_id, oi.quantity, oi.price, g.name, g.img
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN goods g ON oi.product_id = g.id
    WHERE o.id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit();
}

$order_items = [];
while ($row = $result->fetch_assoc()) {
    $order_items[] = $row;
}
$order = $order_items[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Заказ оформлен - ДОДО ПИЦЦА</title>
</head>
<body>
    <div class="navbar-1" id="top-bar">
        <img src="img/logo.avif" class="pidor">
        <a class="nav-button" href="#">DoDo Pizza</a>
        <a class="nav-button" href="index.php">На главную</a>
        <button class="nav-button" href="cart.php"><a class="bi bi-cart2" href="cart.php"></a></button>
    </div>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="text-success">Заказ успешно оформлен!</h2>
            <p class="lead">Номер вашего заказа: #<?php echo $order_id; ?></p>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h4>Детали заказа</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="img/<?php echo $item['img']; ?>" alt="<?php echo $item['name']; ?>" style="width: 50px; height: 50px; object-fit: cover;" class="me-3">
                                            <?php echo $item['name']; ?>
                                        </div>
                                    </td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['price']; ?> ₽</td>
                                    <td><?php echo $item['price'] * $item['quantity']; ?> ₽</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Итого:</strong></td>
                                <td><strong><?php echo $order['total_amount']; ?> ₽</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="index.php" class="but">Вернуться в меню</a>
        </div>
    </div>

    <script src="js/bootstrap.js"></script>
</body>
</html> 