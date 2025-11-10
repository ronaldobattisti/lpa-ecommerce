Folder organization idea:
OnlineStoreFX/
├─ pom.xml                                  ← Maven config (dependencies, build)
├─ README.md
├─ src/
│  ├─ main/
│  │  ├─ java/
│  │  │  └─ com/ronaldobattisti/onlinestore/
│  │  │     ├─ Main.java                   ← App entry point
│  │  │     ├─ app/                       ← Equivalent to “app/” in PHP
│  │  │     │  ├─ controllers/            ← JavaFX Controllers (handle events)
│  │  │     │  │  ├─ LoginController.java
│  │  │     │  │  ├─ ProductController.java
│  │  │     │  │  ├─ CartController.java
│  │  │     │  │  ├─ InvoiceController.java
│  │  │     │  │  └─ UserController.java
│  │  │     │  ├─ database/               ← Equivalent to app/database/
│  │  │     │  │  └─ ConnectionFactory.java
│  │  │     │  └─ models/                 ← Data models / entities
│  │  │     │     ├─ Product.java
│  │  │     │     ├─ User.java
│  │  │     │     ├─ Cart.java
│  │  │     │     └─ Invoice.java
│  │  │     ├─ utils/                     ← Helpers, safe sessions, validators
│  │  │     │  ├─ SceneManager.java
│  │  │     │  ├─ AlertUtils.java
│  │  │     │  └─ CSRFProtection.java
│  │  │     └─ config/
│  │  │        └─ AppConfig.java          ← DB URL, constants, etc.
│  │  └─ resources/
│  │     ├─ fxml/                         ← Equivalent to “includes + pages”
│  │     │  ├─ login.fxml
│  │     │  ├─ products.fxml
│  │     │  ├─ cart.fxml
│  │     │  ├─ invoice.fxml
│  │     │  └─ user_manage.fxml
│  │     ├─ css/                          ← assets/css/
│  │     │  └─ styles.css
│  │     ├─ images/                       ← assets/images/
│  │     │  └─ logo.png
│  │     └─ database/
│  │        └─ schema.sql                 ← DB setup if you want embedded DB
│  └─ test/
│     └─ java/                            ← Optional unit tests
└─ target/                                ← Generated build files (auto)


