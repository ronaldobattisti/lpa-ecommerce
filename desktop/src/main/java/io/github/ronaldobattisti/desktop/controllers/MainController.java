package io.github.ronaldobattisti.desktop.controllers;

import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.control.ScrollPane;

import java.io.IOException;

public class MainController {

    @FXML
    private ScrollPane scrollPane;

    @FXML
    private HeaderController headerController;

    @FXML
    private void initialize() {
        // Inject this controller into the header controller
        if (headerController != null) {
            headerController.setMainController(this);
        }
    }

    public void showLoginPane() throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/login.fxml"));
        Parent loginPane = loader.load();

        scrollPane.setFitToWidth(true);
        scrollPane.setFitToHeight(true);

        scrollPane.setContent(loginPane);
    }

    public void showProductsPane() throws IOException {
        FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/products_pane.fxml"));
        Parent productsPane = loader.load();

        scrollPane.setFitToWidth(true);
        scrollPane.setFitToHeight(true);

        scrollPane.setContent(productsPane);
    }
}
