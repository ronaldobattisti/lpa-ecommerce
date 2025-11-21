module io.github.ronaldobattisti.desktop {
    requires javafx.controls;
    requires javafx.fxml;

    requires org.controlsfx.controls;
    requires org.kordamp.bootstrapfx.core;
    requires java.sql;
    requires java.desktop;
    requires jbcrypt;
    requires javafx.graphics;
    requires org.kordamp.ikonli.javafx;
    requires io.github.ronaldobattisti.desktop;

    //opens io.github.ronaldobattisti.desktop.app to javafx.fxml;
    exports io.github.ronaldobattisti.desktop.app;
    opens io.github.ronaldobattisti.desktop.app to javafx.fxml;
    exports io.github.ronaldobattisti.desktop.controllers;
    opens io.github.ronaldobattisti.desktop.controllers to javafx.fxml;
    exports io.github.ronaldobattisti.desktop.models;
}