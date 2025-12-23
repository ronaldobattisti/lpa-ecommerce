package io.github.ronaldobattisti.desktop.controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.layout.VBox;

public class EditOrderPaneController {
    @FXML
    private VBox root;

    MainController mainController;



    public void setMainControler(MainController mainController){
        this.mainController = mainController;
    }

    public void onCancel(ActionEvent actionEvent) {
    }

    public void onUpdate(ActionEvent actionEvent) {
    }

}
