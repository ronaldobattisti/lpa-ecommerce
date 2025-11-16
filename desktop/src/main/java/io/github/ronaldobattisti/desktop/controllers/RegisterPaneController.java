package io.github.ronaldobattisti.desktop.controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.TextField;

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

    }

    public void showLoginPane(ActionEvent actionEvent) {
        mainController.showLoginPane();
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Node getRoot() {
        return root;
    }
}
