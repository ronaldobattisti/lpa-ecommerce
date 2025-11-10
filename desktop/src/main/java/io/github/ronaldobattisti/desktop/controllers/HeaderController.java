package io.github.ronaldobattisti.desktop.controllers;

import javafx.fxml.FXML;
import javafx.scene.input.MouseEvent;

import java.io.IOException;

public class HeaderController {


    private MainController mainController;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    @FXML
    public void onLoginClicked(MouseEvent mouseEvent) throws IOException {
        if (mainController != null) {
            mainController.showLoginPane();
            System.out.println("Login pressed");
        }
    }

    @FXML
    public void onIconClick(MouseEvent mouseEvent) throws IOException {
        if (mainController != null) {
            mainController.showProductsPane();
            System.out.println("Icon pressed");
        }
    }
}
