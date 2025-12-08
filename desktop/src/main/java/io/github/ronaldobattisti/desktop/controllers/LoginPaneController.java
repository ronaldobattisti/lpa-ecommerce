package io.github.ronaldobattisti.desktop.controllers;

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
        /*try {
            //TRY TO REQUEST FROM API
        } catch (SQLException e) {
            System.out.println("Database error: " + e.getMessage());
            e.printStackTrace();
        } catch (Exception e) {
            System.out.println("Unexpected error: " + e.getMessage());
            e.printStackTrace();
        }*/
        mainController.updateHeader();
    }

    public Node getRoot() {
        return root;
    }

    public void showRegisterPane(ActionEvent actionEvent) {
        mainController.showRegisterPane();
    }


}
