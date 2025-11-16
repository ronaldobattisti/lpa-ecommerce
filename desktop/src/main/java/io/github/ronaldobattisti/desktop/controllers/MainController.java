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
        productsPaneIncludeController.getRoot().setManaged(false);
        productsPaneIncludeController.getRoot().setVisible(false);
        loginPaneIncludeController.getRoot().setManaged(true);
        loginPaneIncludeController.getRoot().setVisible(true);
        registerPaneIncludeController.getRoot().setManaged(false);
        registerPaneIncludeController.getRoot().setVisible(false);
    }

    public void showProductsPane() {
        productsPaneIncludeController.getRoot().setManaged(true);
        productsPaneIncludeController.getRoot().setVisible(true);
        loginPaneIncludeController.getRoot().setManaged(false);
        loginPaneIncludeController.getRoot().setVisible(false);
        registerPaneIncludeController.getRoot().setManaged(false);
        registerPaneIncludeController.getRoot().setVisible(false);
    }

    public void showRegisterPane() {
        productsPaneIncludeController.getRoot().setManaged(false);
        productsPaneIncludeController.getRoot().setVisible(false);
        loginPaneIncludeController.getRoot().setManaged(false);
        loginPaneIncludeController.getRoot().setVisible(false);
        registerPaneIncludeController.getRoot().setManaged(true);
        registerPaneIncludeController.getRoot().setVisible(true);
    }

    public void setUserToHeader(User user) {
        if (headerIncludeController != null) {
            headerIncludeController.setUser(user);
        } else {
            System.out.println("HeaderController not initialized yet.");
        }
    }
}
