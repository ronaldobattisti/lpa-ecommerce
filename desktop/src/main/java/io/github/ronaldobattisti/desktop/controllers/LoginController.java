package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.UserDAO;
import io.github.ronaldobattisti.desktop.models.User;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.layout.HBox;
import java.sql.SQLException;

public class LoginController {

    private MainController mainController;

    @FXML private HBox root;
    @FXML private TextField emailField;
    @FXML private PasswordField passwordField;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void onLoginButtonClick(ActionEvent actionEvent) {
        try {
            UserDAO userDAO = new UserDAO();
            String email = emailField.getText();
            String password = passwordField.getText();

            User user = userDAO.loginCheck(email, password);

            if (user != null) {
                System.out.println("Welcome, " + user.getFirstName() + " " + user.getLastName());

                // Send user to header
                mainController.setUserToHeader(user);

                // Load products screen
                mainController.showProductsPane();
            } else {
                System.out.println("Invalid credentials.");
            }

        } catch (SQLException e) {
            System.out.println("Database error: " + e.getMessage());
            e.printStackTrace();
        } catch (Exception e) {
            System.out.println("Unexpected error: " + e.getMessage());
            e.printStackTrace();
        }
    }

    public Node getRoot() {
        return root;
    }
}
