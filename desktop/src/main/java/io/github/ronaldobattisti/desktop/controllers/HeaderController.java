package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.fxml.FXML;
import javafx.scene.input.MouseEvent;
import org.kordamp.ikonli.javafx.FontIcon;

import java.io.IOException;

public class HeaderController {

    private User currentUser;
    private MainController mainController;

    @FXML private FontIcon adminButton;
    @FXML private FontIcon cartButton;

    @FXML
    public void initialize() {
        currentUser = SessionManager.getCurrentUser();
        this.update();
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
        if (SessionManager.getCurrentUser() == null) {
            mainController.showLoginPane();
            System.out.println("Login pressed");
        } else {
            mainController.showLoggedPane();
            System.out.println("User is already logged in: " + SessionManager.getCurrentUser().getName());
        }
    }

    @FXML
    public void onIconClick(MouseEvent mouseEvent) throws IOException {
        if (mainController != null) {
            mainController.showProductsPane();
            System.out.println("Icon pressed");
        }
    }

    public void update(){
        currentUser = SessionManager.getCurrentUser();
        if (currentUser != null) {
            if (currentUser.isAdm()){
                adminButton.setVisible(true);
                adminButton.setManaged(true);
            } else {
                adminButton.setVisible(false);
                adminButton.setManaged(false);
            }
            cartButton.setVisible(true);
            cartButton.setManaged(true);
            System.out.println("HeaderController initialized with user: " + currentUser.getName());
        } else {
            adminButton.setVisible(false);
            adminButton.setManaged(false);
            cartButton.setVisible(false);
            cartButton.setManaged(false);
            System.out.println("HeaderController initialized with no user.");
        }
    }

    public void onAdmClicked(MouseEvent mouseEvent) {
        System.out.println("Admin pressed");
        mainController.showAdmPane();
    }

    public void onCartClicked(MouseEvent mouseEvent) {
        System.out.println("Cart pressed");
    }
}
