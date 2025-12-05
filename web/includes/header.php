<?php
    include __DIR__ . '/../assets/disable_cache.php';
    include __DIR__ . '/../assets/start_session_safe.php';

    $person_tn = 'bi bi-person';
    $link = 'login.php';

    if (!empty($_SESSION['user_name'])){
        $link = 'config.php';
        if ($_SESSION['user_isadm']){
            $person_tn = 'bi bi-person-plus-fill';
        } else {
            $person_tn = 'bi bi-person-check';
        }
    } else {
        $_SESSION['user_name'] = false;
    }
?>

<header class="site-header">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <div class="header-container">

        <!-- Left: Logo -->
        <div class="header-logo">
            <a href="index.php">
                <img src="assets/images/Logo.png" alt="TempLogo">
            </a>
        </div>

        <!-- Center: Search -->
        <form method="GET" action="index.php" class="search-bar">
            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
            >
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <!-- Right: Icons -->
        <div class="header-icons">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_isadm']): ?>
                <a href="adm_page.php" title="Admin Panel">
                <i class="bi bi-stars"></i>
                </a>
            <?php endif; ?>

            <a href="<?= $link ?>" title="Account">
                <i class="<?= $person_tn ?>"></i>
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="cart.php" title="Cart">
                <i class="bi bi-bag"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
    
</body>