package io.github.ronaldobattisti.desktop.controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.layout.VBox;

public class ManageClientsPaneController {

    @FXML private VBox root;

    private MainController mainController;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void onSearchClick(ActionEvent actionEvent) {
    }

    public void onClearClick(ActionEvent actionEvent) {
    }

    public Node getRoot() {
        return root;
    }

    public void updateClientsList() {
        System.out.println("Updating clients list...");
    }
}
