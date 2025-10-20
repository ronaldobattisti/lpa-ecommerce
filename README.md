# TempStore
Online store webpage

To clarify: 
-Differences btw get_result() and store_result();
-How $_SESSION variables works;

Ajax used in cart:
    -change quantity

Notes:
    config/site.php:
        » Created a const BASE_URL, which will make it easier to change all URL's when the website be deployed

    General:
        » User __DIR__ in front of the paths to avoid errors when fetching other pages. __DIR__ returns the absolute path of the directory where the current php file is located.

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
