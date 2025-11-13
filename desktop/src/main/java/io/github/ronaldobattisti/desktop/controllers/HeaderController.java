package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.fxml.FXML;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.HBox;
import java.io.IOException;

public class HeaderController {

    private User currentUser;
    private MainController mainController;

    @FXML
    public void initialize() {
        currentUser = SessionManager.getCurrentUser();
        if (currentUser != null) {
            System.out.println("HeaderController initialized with user: " + currentUser.getName());
        } else {
            System.out.println("HeaderController initialized with no user.");
        }

    }

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

    public void onAdmClicked(MouseEvent mouseEvent) {
        System.out.println("Admin pressed");
    }

    public void onCartClicked(MouseEvent mouseEvent) {
        System.out.println("Cart pressed");
    }
}
