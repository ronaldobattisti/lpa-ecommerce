package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.UserDAO;
import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.Alert;
import javafx.scene.control.TextField;

import java.sql.SQLException;

public class RegisterPaneController {

    private MainController mainController;
    @FXML private Node root;
    @FXML private TextField firstNameField;
    @FXML private TextField lastNameField;
    @FXML private TextField emailField;
    @FXML private TextField passwordField;
    @FXML private TextField addressField;
    @FXML private TextField phoneField;

    public void onRegisterButtonClick(ActionEvent actionEvent) {
        System.out.println("Register button clicked");
        String firstName = firstNameField.getText();
        String lastName = lastNameField.getText();
        String email = emailField.getText();
        String password = passwordField.getText();
        String address = addressField.getText();
        String phone = phoneField.getText();

        User user = registerUser(firstName, lastName, email, password, address, phone);

        if (user != null) {
            SessionManager.setCurrentUser(user);
            mainController.showProductsPane();
        }
        else  {
            Alert alert = new Alert(Alert.AlertType.INFORMATION);
        }
    }

    public void showLoginPane(ActionEvent actionEvent) {
        mainController.showLoginPane();
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    private User registerUser(String firstName, String lastName, String email, String password, String address, String phone) {
        try{
            User user = new User(firstName, lastName, email, password, address, phone);
            UserDAO userDAO = new UserDAO();
            if (!userDAO.checkEmailExists(user)){
                userDAO.registerNewUser(user);
                return user;
            } else {
                throw new SQLException("User already exists");
            }
        } catch (Exception e) {
            System.out.println("Error during registration: " + e.getMessage());
            e.printStackTrace();
        }
        return null;
    }

    public Node getRoot() {
        return root;
    }
}
