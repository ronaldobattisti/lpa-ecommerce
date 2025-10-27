# TempStore
Online store webpage

This application is being designed to improve my knowledges in ful-stack development.
After working on some project with C#, I decided to explore more technologies to be able to develop solutions in a more efficient way, thats why this idea came. The main goal of this project is to develop an online store, with all resources a real store would have.

My main goals are to learn and use the following tools:
» AJAX: Used in the cart system to create a smoother and more responsive user experience;
» PHP and JS: Focused on enabling seamless interaction between server-side and client-side code;
» UI and UX: Ensuring the interface is intuitive and user-friendly;
» Java: Revisiting cross-platform application development using HTTP requests and CRUD operations;
» Android Studio: Learning the fundamentals of Android app development.

At the moment, the database is hosted locally for testing and development.
The application will be deployed online once it reaches a stable version.

Summary:

Ajax used in cart:
    -change quantity

Notes:
    config/site.php:
        » Created a const BASE_URL, which will make it easier to change all URL's when the website be deployed

    General:
        » User __DIR__ in front of the paths to avoid errors when fetching other pages. __DIR__ returns the absolute path of the directory where the current php file is located.
        » 

    Cart:
        » Ajax -> standard pattern:
            fetch(link, {
                        method: 'POST', // GET, POST, PUT, DELETE...
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'id=1&quant=3' // Data you’re sending (for POST/PUT)
                        })
                .then(response => { /* handle raw HTTP response */ })
                .then(data => { /* handle parsed data (usually JSON) */ })
                .catch(error => { /* handle any network or parsing errors */ });

        » Change instantly the price:
            let priceText = this.closest('tr').querySelector('td:nth-child(3)').innerText;
            //select the innerText of the 3rd collumn in this line

    Menu:
        » Hold user selection on select tag:
            <!-- If category is not selected or category == '', 'all categories' is gonna be setted s selected -->
            <!-- (condition) ? (value if true) : (value if false) -->
            <option value='' <?= !isset($_GET['category']) || $_GET['category'] == '' ? 'selected' : '' ?>>All categories</option>








Quoting php in html:


__DIR__:
    » Gives the phisical folder path (server/computer)
    » Used inside PHP for includes or file handling
    » Not visible to the browser
    » <?php include __DIR__ . '/inludes/header.php'; ?>

BASE_URL:
    » Constant defined
    » <?php echo BASE_URL . '/assets/css/styles.css'; ?>

    To clarify: 
-Differences btw get_result() and store_result();
-How $_SESSION variables works;
