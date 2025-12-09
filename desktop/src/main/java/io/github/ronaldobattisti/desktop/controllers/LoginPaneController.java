package io.github.ronaldobattisti.desktop.controllers;

import com.mysql.cj.Session;
import io.github.ronaldobattisti.desktop.api.UsersApiClient;
import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.PasswordUtils;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.layout.VBox;

public class LoginPaneController {

    private MainController mainController;

    @FXML private VBox root;
    @FXML private TextField emailField;
    @FXML private PasswordField passwordField;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void onLoginButtonClick(ActionEvent actionEvent) {
        User user = new User();
        user = UsersApiClient.getUserByEmail(emailField.getText());
        boolean correctPassword = PasswordUtils.checkPassword(user.getPassword(), passwordField.getText());
        if (correctPassword) {
            System.out.println("Login successful for user: " + user.getFirstName());
            SessionManager.setCurrentUser(user);
            mainController.updateHeader();
            mainController.showProductsPane();
        } else {
            System.out.println("Login failed for email: " + emailField.getText());
        }
    }

    public Node getRoot() {
        return root;
    }

    public void showRegisterPane(ActionEvent actionEvent) {
        mainController.showRegisterPane();
    }


}
