<?php
    include __DIR__ . '/../app/database/connection.php';
    include __DIR__ . '/../assets/start_session_safe.php';

    //Using GET because there's no sensitive content, thats why
    //enchange="this.form.submit()" is being used
    //$GET['category'] ?? '' => if there is a value, use otherwise ''.
    $_SESSION['category'] = $_GET['category'] ?? '';

?>

<header>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <form method="GET" action="">
        <label for="category">Filter by category:</label>
        <select name="category" id="category" onchange="this.form.submit()">
            <option value="">All categories</option>
            <option value="desktop">Desktop</option>
            <option value="laptop">Laptop</option>
            <option value="component">Component</option>
            <option value="storage">Storage</option>
            <option value="peripheral">Peripheral</option>
            <option value="display">Display</option>
            <option value="network">Network</option>
            <option value="printer">Printer</option>
        </select>
    </form>
</header>