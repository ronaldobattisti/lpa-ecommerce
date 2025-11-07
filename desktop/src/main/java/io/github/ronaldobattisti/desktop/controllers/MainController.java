package io.github.ronaldobattisti.desktop.controllers;

import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.Label;

public class MainController {
    @FXML
    private ProductsGridController productsGridController;

    @FXML
    private void initialize() {
        System.out.println("Main controller initialized");
        if (productsGridController != null) {
            System.out.println("Main controller initialized");
        } else
            System.out.println("Main controller not initialized");
    }
}
