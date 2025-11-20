package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.Hyperlink;
import javafx.scene.control.Label;
import javafx.scene.layout.VBox;

public class LoggedPaneController {

    private MainController mainController;

    @FXML private VBox root;
    @FXML private Label welcomeLabel;

    @FXML private void initialize() {
    }

    public void refresh() {
        if (SessionManager.getCurrentUser() != null){
            welcomeLabel.setText("");
            welcomeLabel.setText("Welcome to your account settings, " + SessionManager.getCurrentUser().getName());
        }
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Node getRoot() {
        return root;
    }

    public void onLogoutClick(ActionEvent actionEvent) {
        SessionManager.logout();
        mainController.updateHeader();
        mainController.showProductsPane();
    }
}
