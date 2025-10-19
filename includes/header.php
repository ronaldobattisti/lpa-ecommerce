<?php
    include 'assets/disable_cache.php';
    include 'assets/start_session_safe.php';

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


<header>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <div class="header-item"; id="header-logo">
        <a href="index.php">
            <img class="header-logo"; src="images/Logo.png" alt="TempLogo">
        </a>
    </div>
    <div class="header-item">
        <input type="text" class="grow" id="search-bar" placeholder="Search...">
        <button type="button">
            <i class="bi bi-search"></i>
        </button>
    </div>
    <div class="header-item">
        <!--Invoking php in the html to test variable-->
        <!--test is the session was already initialized and not null-->
        <?php if (isset($_SESSION['user_id'])) :?>
            <!--test if user is ADM-->
            <?php if ($_SESSION['user_isadm']) :?>
                <a href="adm_page.php">
                    <i class="bi bi-stars"></i>
                </a>
            <?php endif; ?>
        <?php endif; ?>
        <!--end test-->
       
        <a href="<?php echo $link ?>">
            <i class="<?php echo $person_tn; ?>"></i>
        </a>

        <?php if (isset($_SESSION['user_id'])) :?>
            <a href="cart.php">
                <i class="bi bi-bag"></i>
            </a>
        <?php endif; ?>
    </div>
</header>

<body>
    
</body>