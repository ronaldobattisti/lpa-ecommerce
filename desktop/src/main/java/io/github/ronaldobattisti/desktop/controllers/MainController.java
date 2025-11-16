package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.User;
import javafx.fxml.FXML;

public class MainController {

    @FXML private HeaderController headerIncludeController;
    @FXML private LoginPaneController loginPaneIncludeController;
    @FXML private ProductsPaneController productsPaneIncludeController;
    @FXML private RegisterPaneController registerPaneIncludeController;

    @FXML
    private void initialize() {
        headerIncludeController.setMainController(this);
        loginPaneIncludeController.setMainController(this);
        productsPaneIncludeController.setMainController(this);
        registerPaneIncludeController.setMainController(this);
        // show products first
        showProductsPane();
    }

    public void showLoginPane() {
        productsPaneIncludeController.getRoot().setVisible(false);  // hide
        loginPaneIncludeController.getRoot().setVisible(true);   // show again
    }

    public void showProductsPane() {
        productsPaneIncludeController.getRoot().setVisible(true);  // hide
        loginPaneIncludeController.getRoot().setVisible(false);   // show again
    }

    public void setUserToHeader(User user) {
        if (headerIncludeController != null) {
            headerIncludeController.setUser(user);
        } else {
            System.out.println("HeaderController not initialized yet.");
        }
    }
}
