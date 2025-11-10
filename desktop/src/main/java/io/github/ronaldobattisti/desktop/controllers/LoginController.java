package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.UserDAO;
import io.github.ronaldobattisti.desktop.models.User;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;

import java.sql.SQLException;

public class LoginController {

    @FXML
    private TextField emailField;

    @FXML
    private PasswordField passwordField;

    UserDAO userDAO = new UserDAO();

    public void onLoginButtonClick(ActionEvent actionEvent) throws SQLException {
        UserDAO userDAO = new UserDAO();

        String email = emailField.getText();
        String password = passwordField.getText();
        System.out.println("email: " + email + " password: " + password);

        User user = userDAO.loginCheck(email, password);

        System.out.println("Welcome, " + user.getFirstName() + " " + user.getLastName());
    }
}
