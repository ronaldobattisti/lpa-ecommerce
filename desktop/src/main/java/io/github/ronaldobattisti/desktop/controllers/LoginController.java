package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.UserDAO;
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
        String email = emailField.getText();
        String password = passwordField.getText();
        System.out.println("email: " + email + " password: " + password);

        userDAO.loginCheck(email, password);

    }
}
