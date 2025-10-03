<?php
session_start();
require_once "db.php";

$sql = "SELECT * FROM goods ORDER BY category";
$result = $mysqli->query($sql);

$goodsByCategory = [
    'pizza' => [],
    'snacks' => [],
    'salads' => [],
    'drinks' => []
];

while ($row = $result->fetch_assoc()) {
    $goodsByCategory[$row['category']][] = $row;
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
    <title>Document</title>
</head>

<body>
        <div class="navbar-1" id="top-bar">
        <img src="img/pizza1.png" class="pidor">
        <a class="nav-button" href="#info">О нас</a>0
        <a class="nav-button" href="#novinki">Новинки</a>
        <a class="nav-button" href="#">Комбо</a>
        <a class="nav-button" href="#">Пиццы</a>
        <a class="nav-button" href="#">Закуски</a>
        <a class="nav-button" href="#">Напитки</a>
        <a class="nav-button" href="#">Десерты</a>
        <?php if (!empty($_SESSION['cart'])): ?>
            <button class="nav-button" href="cart.php" style="position:relative;">
                <a class="bi bi-cart2" href="cart.php"></a>
                <span class="cart-indicator-dot"></span>
            </button>
        <?php else: ?>
            <button class="nav-button" href="cart.php"><a class="bi bi-cart2" href="cart.php"></a></button>
        <?php endif; ?>
    </div>

    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/carucel1.jpg" class="d-block w-100" alt="" draggable="false">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/carucel2.jpg" class="d-block w-100" alt="" draggable="false">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/carusel3.jpg" class="d-block w-100" alt="" draggable="false">
                <div class="carousel-caption d-none d-md-block">
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <div id="info" class="container my-5">
        <section class="row mb-5">
            <div class="col-md-6">
                <img src="img/int.png" alt="Интерьер пиццерии" class="img-fluid rounded" draggable="false">
            </div>
            <div class="col-md-6">
                <h2>О нас</h2>
                <p>"La Piazza Deliziosa" — это уютная пиццерия, где каждая пицца готовится с любовью и традициями
                    итальянской кухни. Мы используем только свежайшие ингредиенты и готовим по старинным рецептам.</p>
                <p>Наше тесто замешивается вручную, а соусы и начинки готовятся ежедневно, чтобы сохранить аутентичный
                    вкус.</p>
            </div>
        </section>
        <section class="mb-5">
            <h2>Новинки</h2>
            <hr>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="img/pizza.avif" class="card-img-top" alt="Пицца" draggable="false">
                        <div class="card-body">
                            <h5 class="card-title">Классические пиццы</h5>
                            <p class="card-text">Маргарита, Пепперони, Четыре сыра, Гавайская и другие.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="img/omlet.avif" class="card-img-top" alt="Закуски" draggable="false">
                        <div class="card-body">
                            <h5 class="card-title">Закуски и салаты</h5>
                            <p class="card-text">Брускетты, чесночные хлебцы, салаты с итальянскими специями.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="img/coks.avif" class="card-img-top" alt="Десерты" draggable="false">
                        <div class="card-body">
                            <h5 class="card-title">Десерты</h5>
                            <p class="card-text">Тирамису, панна-кота, чизкейк и другие сладости.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <?php
    $categoryTitles = [
        'pizza' => 'Пицца',
        'snacks' => 'Закуски',
        'salads' => 'Салаты',
        'drinks' => 'Напитки'
    ];

    foreach ($goodsByCategory as $category => $items):
        if (!empty($items)):
            ?>
            <h2><?php echo $categoryTitles[$category]; ?></h2>
            <hr>
            <div class="con">
                <?php foreach ($items as $row):
                    $dialogModal = $row['name'] . $row['id'];
                    $dialogModal = str_replace(' ', '', $dialogModal);
                    ?>
                    <div class="card">
                        <img src="img/<?php echo $row['img']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <h3><?php echo $row['price']; ?>P.</h3>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <button class="but" onclick="<?php echo $dialogModal; ?>.showModal()">Выбрать</button>
                        </div>
                    </div>

                    <dialog class="dialog-wrapper" id="<?php echo $dialogModal; ?>">
                        <button class="close" onclick="<?php echo $dialogModal; ?>.close()"><i class="bi bi-x-lg"></i></button>
                        <img class="img" src="img/<?php echo $row['img']; ?>" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <h3><?php echo $row['price']; ?>P.</h3>
                            <p class="card-text"><?php echo $row['description']; ?></p>
                            <form method="POST" action="cart.php" class="d-flex align-items-center justify-content-center">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1" class="form-control me-2" style="width: 80px;">
                                <button type="submit" class="but">В корзину</button>
                            </form>
                        </div>
                    </dialog>
                <?php endforeach; ?>
            </div>
        <?php
        endif;
    endforeach;
    ?>


    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-center">
                        <img src="img/pizza1.png" alt="Logotype" width="50px" height="50px" draggable="false"
                            class="me-2">
                        <h5 class="text-uppercase fw-bold mb-0">додо Пицца</h5>
                    </div>
                    <p class="small">Выручка российской сети в этом месяце. В прошлом — 10 ₽</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-uppercase fw-bold">Меню</h5>
                    <ul class="list-unstyled">
                        <li><a href="info.php" class="text-light text-decoration-none">О нас</a></li>
                        <li><a href="servies.php" class="text-light text-decoration-none">Услуги</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Контакты</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-uppercase fw-bold">Мы в соцсетях</h5>
                    <a href="#" class="text-light me-2"><i class="bi bi-telegram"></i></a>
                    <a href="#" class="text-light me-2"><i class="bi bi-github"></i></a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="110" height="23" fill="none" fill-rule="evenodd">
                        <path class="svg-logo"
                            d="M19.158 21.912l-8.543-10.595 8.012-9.368H13.32L1.9 16.188v5.723h4.297V15.78l1.575-1.857 6.095 7.99h5.3zm22.907 0L47.8 1.932h-4.828l-3.5 14.427-3.8-14.427h-3.356L28.472 16.36 24.928 1.932h-4.81l5.77 19.963h4.554l3.5-13.712 3.527 13.712h4.588v.017zm16.95.358c6.095 0 10.546-4.31 10.546-10.322s-4.434-10.34-10.546-10.34c-6.078 0-10.512 4.31-10.512 10.322s4.434 10.34 10.512 10.34zm0-3.78c-3.715 0-6.095-2.845-6.095-6.558 0-3.747 2.38-6.558 6.095-6.558s6.13 2.8 6.13 6.558c0 3.713-2.414 6.558-6.13 6.558zm30.132 3.424L84.6 14.315c2.174-.51 4.417-2.402 4.417-5.928 0-3.713-2.568-6.44-6.763-6.44H72.83v19.963h4.297V14.81h3.15l3.955 7.103h4.914zm-7.533-10.85H77.11V5.68h4.503c1.73 0 3.013 1.022 3.013 2.69.017 1.686-1.284 2.69-3.013 2.69zM110 21.912l-8.56-10.595 8.012-9.368h-5.3l-7.122 8.925V1.932h-4.297v19.963h4.297v-6.132l1.575-1.857 6.095 7.99h5.3v.017z"
                            fill="white"></path>
                        <path d="M6.198 6.087L1.9 11.283V4.435H0v-2.59h6.198v4.24z" fill="#ffa800"></path>
                    </svg>
                </div>
            </div>
            <hr class="border-light">
            <div class="text-center small">
                &copy; 2025 Enigma. Все права защищены. | <a href="#" class="link-light">Политика конфиденциальности</a>
            </div>
        </div>
    </footer>

 <dialog class="dialog-wrapper" id="cookie-accept">
    <p>Мы используем cookie</p>
    <button id="accept-btn">принять</button>
    <button id="reject-btn">отклонить</button>
</dialog>

    <script src="js/bootstrap.js"></script>
    <script>
    // Фиксация скролла при открытии dialog
    (function(){
        let scrollY = 0;
        document.querySelectorAll('dialog.dialog-wrapper').forEach(dialog => {
            dialog.addEventListener('show', () => {
                scrollY = window.scrollY;
                document.body.style.position = 'fixed';
                document.body.style.top = `-${scrollY}px`;
                document.body.style.left = '0';
                document.body.style.right = '0';
                document.body.style.width = '100%';
            });
            dialog.addEventListener('close', () => {
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.left = '';
                document.body.style.right = '';
                document.body.style.width = '';
                window.scrollTo(0, scrollY);
            });
        });
        // Переопределяем showModal и close для генерации событий
        const origShowModal = HTMLDialogElement.prototype.showModal;
        HTMLDialogElement.prototype.showModal = function() {
            origShowModal.apply(this, arguments);
            this.dispatchEvent(new Event('show'));
        };
        const origClose = HTMLDialogElement.prototype.close;
        HTMLDialogElement.prototype.close = function() {
            origClose.apply(this, arguments);
            this.dispatchEvent(new Event('close'));
        };
    })();
    </script>
    <script src="./js/cookies.js"></script>
</body>
</html>