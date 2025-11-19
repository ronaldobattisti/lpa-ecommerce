package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.User;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.layout.Region;
import javafx.scene.layout.StackPane;

public class MainController {

    @FXML private HeaderController headerIncludeController;
    @FXML private LoginPaneController loginPaneIncludeController;
    @FXML private ProductsPaneController productsPaneIncludeController;
    @FXML private RegisterPaneController registerPaneIncludeController;
    @FXML private LoggedPaneController loggedPaneIncludeController;
    @FXML private StackPane contentArea;

    @FXML
    private void initialize() {
        // Inject back reference
        headerIncludeController.setMainController(this);
        loginPaneIncludeController.setMainController(this);
        productsPaneIncludeController.setMainController(this);
        registerPaneIncludeController.setMainController(this);
        loggedPaneIncludeController.setMainController(this);

        // Bind each pane to fill the content area
        bindPane(loginPaneIncludeController.getRoot());
        bindPane(productsPaneIncludeController.getRoot());
        bindPane(registerPaneIncludeController.getRoot());
        bindPane(loggedPaneIncludeController.getRoot());

        // Start with products pane visible (others hidden)
        showProductsPane();
    }

    private void bindPane(Node pane) {
        if (pane instanceof Region r) {
            r.prefWidthProperty().bind(contentArea.widthProperty());
            r.prefHeightProperty().bind(contentArea.heightProperty());
            r.maxWidthProperty().bind(contentArea.widthProperty());
            r.maxHeightProperty().bind(contentArea.heightProperty());
        }
    }

    public void showLoginPane() {
        productsPaneIncludeController.getRoot().setManaged(false);
        productsPaneIncludeController.getRoot().setVisible(false);
        loginPaneIncludeController.getRoot().setManaged(true);
        loginPaneIncludeController.getRoot().setVisible(true);
        registerPaneIncludeController.getRoot().setManaged(false);
        registerPaneIncludeController.getRoot().setVisible(false);
        loggedPaneIncludeController.getRoot().setManaged(false);
        loggedPaneIncludeController.getRoot().setVisible(false);
    }

    public void showProductsPane() {
        productsPaneIncludeController.getRoot().setManaged(true);
        productsPaneIncludeController.getRoot().setVisible(true);
        loginPaneIncludeController.getRoot().setManaged(false);
        loginPaneIncludeController.getRoot().setVisible(false);
        registerPaneIncludeController.getRoot().setManaged(false);
        registerPaneIncludeController.getRoot().setVisible(false);
        loggedPaneIncludeController.getRoot().setManaged(false);
        loggedPaneIncludeController.getRoot().setVisible(false);
    }

    public void showRegisterPane() {
        productsPaneIncludeController.getRoot().setManaged(false);
        productsPaneIncludeController.getRoot().setVisible(false);
        loginPaneIncludeController.getRoot().setManaged(false);
        loginPaneIncludeController.getRoot().setVisible(false);
        registerPaneIncludeController.getRoot().setManaged(true);
        registerPaneIncludeController.getRoot().setVisible(true);
        loggedPaneIncludeController.getRoot().setManaged(false);
        loggedPaneIncludeController.getRoot().setVisible(false);
    }

    public void showLoggedPane() {
        productsPaneIncludeController.getRoot().setManaged(false);
        productsPaneIncludeController.getRoot().setVisible(false);
        loginPaneIncludeController.getRoot().setManaged(false);
        loginPaneIncludeController.getRoot().setVisible(false);
        registerPaneIncludeController.getRoot().setManaged(false);
        registerPaneIncludeController.getRoot().setVisible(false);
        loggedPaneIncludeController.getRoot().setManaged(true);
        loggedPaneIncludeController.getRoot().setVisible(true);
        loggedPaneIncludeController.refresh();
    }

}
