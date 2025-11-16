package io.github.ronaldobattisti.desktop.controllers;

import javafx.event.ActionEvent;

public class RegisterPaneController {

    private MainController mainController;

    public void onRegisterButtonClick(ActionEvent actionEvent) {
        System.out.println("Register button clicked");
    }

    public void showLoginPane(ActionEvent actionEvent) {
        mainController.showLoginPane();
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }
}
