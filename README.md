# TempStore

# To Implement:
- Check user when loading all pager, if not connect, redirec to index
- Images on the cloud


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

    Products_div:
        » $params[] -> ...$params = params[0], params[1], ..., params[n];






Quoting php in html:

__DIR__:
    » Gives the phisical folder path (server/computer)
    » Used inside PHP for includes or file handling
    » Not visible to the browser
    » <?php include __DIR__ . '/includes/header.php'; ?>

BASE_URL:
    » Constant defined
    » <?php echo BASE_URL . '/assets/css/styles.css'; ?>

    To clarify: 
-Differences btw get_result() and store_result();
-How $_SESSION variables works;

>>Completed (already implemented)<<

» Project basics — DB connection, sessions and includes (index, connection.php, start_session_safe.php, header/footer). (completed)
Product CRUD UI — product_register.php, product_manage.php, product listing. (completed)

» Shopping cart — add/update/delete and display (ajax/add_cart.php, ajax/update_cart_quantity.php, ajax/delete_from_cart.php, cart.php). (completed)

» Invoice creation — server endpoint and client flow (ajax/create_invoice.php, cart.php JS). (completed)

» Order management UI — order listing and modal edit form, server-side update (order_manage.php). (completed)

» Includes & path robustness — use of DIR and centralized BASE_URL. (completed)

» Styling and layout fixes — stylesheet and footer placement improvements. (completed)

>>In progress / partially done<<

» Input validation & sanitization — some prepared statements exist, but central validation and sanitization need to be completed for all forms and endpoints. (in-progress)

» Error handling & logging — endpoints now return JSON, but central logging and removal of dev logs should be finalized. (in-progress)

» UX polish & accessibility — button disabling and row-removal implemented; consider empty-cart message and modal ARIA roles. (in-progress)

>>Not started / recommended next steps (prioritized)<<

» Fix lpa_invoice_items schema so one invoice can have many lines (urgent)

    Preferred: change primary key to composite (lpa_invitem_inv_no, lpa_invitem_stock_id)

    ALTER TABLE lpa_invoice_items DROP PRIMARY KEY, ADD PRIMARY KEY (lpa_invitem_inv_no, lpa_invitem_stock_id);

    Alternate: add an auto-increment id column

    Always backup table before running ALTER. (not-started)

» Normalize invoice/payment enum values (important)
    Make stored values consistent across code and DB (e.g., payment: 'pending'/'paid'; status: 'u'/'s'/'p' or full words). Update create_invoice.php and order_manage.php to use exactly the same values. (not-started)

» CSRF protection (important for security)
    Add tokens to all POST forms and validate server-side for ajax/create_invoice.php, order_manage.php, product edits. (not-started)

» Permissions & auth checks (important)
    Restrict admin pages and AJAX endpoints to authorized roles. (not-started)

» Database migrations & backups (operational)
    Add a small migrations folder with SQL files and an instruction in README to run backups. (not-started)

» Tests & automated checks (nice to have)
    Add a few integration tests (PHP scripts or PHPUnit) for AJAX endpoints. (not-started)

» Documentation (setup + how to run) (helpful for assessment)
    README with steps to import DB, set BASE_URL, run on XAMPP, and note known issues. (not-started)