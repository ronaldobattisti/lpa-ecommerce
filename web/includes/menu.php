<?php
    include __DIR__ . '/../app/database/connection.php';
    include __DIR__ . '/../assets/start_session_safe.php';

    //Using GET because there's no sensitive content, thats why
    //enchange="this.form.submit()" is being used
    //$GET['category'] ?? '' => if there is a value, use otherwise ''.
    $_SESSION['category'] = $_GET['category'] ?? '';

?>
<html>
    <header>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
        <form method="GET" action="">
            <label for="category">Filter by category:</label>
            <select name="category" id="category" onchange="this.form.submit()">
                <!-- If category is not selected or category == '', 'all categories' is gonna be setted s selected -->
                <!-- (condition) ? (value if true) : (value if false) -->
                <option value='' <?= !isset($_GET['category']) || $_GET['category'] == '' ? 'selected' : '' ?>>All categories</option>
                <option value="desktop" <?= !isset($_GET['category']) || $_GET['category'] == 'desktop' ? 'selected' : '' ?>>Desktop</option>
                <option value="laptop" <?= !isset($_GET['category']) || $_GET['category'] == 'laptop' ? 'selected' : '' ?>>Laptop</option>
                <option value="component" <?= !isset($_GET['category']) || $_GET['category'] == 'component' ? 'selected' : '' ?>>Component</option>
                <option value="storage" <?= !isset($_GET['category']) || $_GET['category'] == 'storage' ? 'selected' : '' ?>>Storage</option>
                <option value="peripheral" <?= !isset($_GET['category']) || $_GET['category'] == 'peripheral' ? 'selected' : '' ?>>Peripheral</option>
                <option value="display" <?= !isset($_GET['category']) || $_GET['category'] == 'display' ? 'selected' : '' ?>>Display</option>
                <option value="network" <?= !isset($_GET['category']) || $_GET['category'] == 'network' ? 'selected' : '' ?>>Network</option>
                <option value="printer" <?= !isset($_GET['category']) || $_GET['category'] == 'printer' ? 'selected' : '' ?>>Printer</option>
            </select>
        </form>
    </header>
</html>