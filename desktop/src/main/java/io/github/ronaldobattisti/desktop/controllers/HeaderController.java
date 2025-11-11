package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.User;
import javafx.fxml.FXML;
import javafx.scene.input.MouseEvent;

import java.io.IOException;

public class HeaderController {

    private User currentUser;
    private MainController mainController;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public HeaderController getHeaderController(){
        return this;
    }

    public void setUser(User user) {
        this.currentUser = user;
        System.out.println("User set in HeaderController: " + user.getName());
    }

    public User getCurrentUser() {
        return currentUser;
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
