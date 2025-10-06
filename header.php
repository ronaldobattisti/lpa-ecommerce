<?php
    // Disable caching for test
    header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies and browsers

    session_start();

    $link = 'login.php';
    $person_tn = 'bi bi-person';

    if (!empty($_SESSION['user_name'])){
        $link = 'config.php';
        $person_tn = 'bi bi-person-check';
    }

?>

<link rel="stylesheet" href="css/styles.css">

<header>
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
        <<a href="<?php echo $link; ?>">>
            <i class="<?php echo $person_tn; ?>"></i>
        </a>

        <i class="bi bi-bag"></i>
    </div>
</header>