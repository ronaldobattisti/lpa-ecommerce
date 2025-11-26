package io.github.ronaldobattisti.desktop.controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.layout.VBox;

public class ManageOdersPaneController {

    @FXML private VBox root;

    private MainController mainController;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Node getRoot() {
        return (Node) root;
    }

    public void onSearchClick(ActionEvent actionEvent) {
    }

    public void onClearClick(ActionEvent actionEvent) {
    }

    public void updateOrdersList() {
    }
}
