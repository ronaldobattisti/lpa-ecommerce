module io.github.ronaldobattisti.desktop {
    requires javafx.controls;
    requires javafx.fxml;
    opens io.github.ronaldobattisti.desktop.models to com.fasterxml.jackson.databind;
    requires org.controlsfx.controls;
    requires org.kordamp.bootstrapfx.core;
    requires java.sql;
    requires java.desktop;
    requires jbcrypt;
    requires javafx.graphics;
    requires org.kordamp.ikonli.javafx;
    requires jdk.compiler;
    requires com.google.gson;
    requires java.net.http;
    requires com.fasterxml.jackson.databind;
    requires com.fasterxml.jackson.core;
    requires mysql.connector.j;
    requires com.fasterxml.jackson.annotation;
    requires javafx.base;
    requires com.gluonhq.charm.glisten;
    exports io.github.ronaldobattisti.desktop.app;
    opens io.github.ronaldobattisti.desktop.app to javafx.fxml;
    exports io.github.ronaldobattisti.desktop.controllers;
    opens io.github.ronaldobattisti.desktop.controllers to javafx.fxml;
    exports io.github.ronaldobattisti.desktop.models;
}