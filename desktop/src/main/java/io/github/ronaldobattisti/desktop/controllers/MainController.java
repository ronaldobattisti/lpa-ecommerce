package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.User;
import javafx.fxml.FXML;
import javafx.scene.control.ScrollPane;
import javafx.scene.layout.BorderPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.StackPane;

public class MainController {

    @FXML private BorderPane rootPane;
    @FXML private ScrollPane scrollPane;
    @FXML private StackPane contentArea;

    // from fx:include
    @FXML private HBox header; // this matches <fx:include fx:id="header" ...> in main.fxml

    @FXML private LoginController loginController;
    @FXML private ProductsPaneController productsController;

    // manually loaded controller reference
    private HeaderController headerController;

    @FXML
    private void initialize() {
        try {
            // --- load HeaderController manually since fx:id="header" points to the HBox root
            javafx.fxml.FXMLLoader headerLoader = new javafx.fxml.FXMLLoader(
                    getClass().getResource("/io/github/ronaldobattisti/desktop/components/header.fxml"));
            headerLoader.load();
            headerController = headerLoader.getController();

            // inject MainController into children
            headerController.setMainController(this);
            loginController.setMainController(this);
            productsController.setMainController(this);

            // show login first
            showLoginPane();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /** show login screen */
    public void showLoginPane() {
        loginController.getRoot().toFront();
    }

    /** show products screen */
    public void showProductsPane() {
        productsController.getRoot().toFront();
    }

    /** pass user info to header after login */
    public void setUserToHeader(User user) {
        if (headerController != null) {
            headerController.setUser(user);
        } else {
            System.out.println("HeaderController not initialized yet.");
        }
    }
}
