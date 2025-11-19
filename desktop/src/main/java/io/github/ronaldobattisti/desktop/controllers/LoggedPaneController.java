package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.fxml.FXML;
import javafx.scene.Node;
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
            System.out.println(welcomeLabel.getText() + " " + SessionManager.getCurrentUser().getName());
            welcomeLabel.setText(welcomeLabel.getText() + " " + SessionManager.getCurrentUser().getName());
        }
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void showLoggedPane() {
        mainController.showLoggedPane();
    }

    public Node getRoot() {
        return root;
    }
}
