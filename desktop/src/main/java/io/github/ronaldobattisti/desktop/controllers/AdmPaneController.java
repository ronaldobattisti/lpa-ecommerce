package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.VBox;

import javafx.scene.control.Label;

public class AdmPaneController {
    MainController mainController;

    @FXML private VBox root;
    @FXML private Label welcomeLabel;

    @FXML
    public void initialize() { }

    public void update(){
        welcomeLabel.setText("Welcome to the Admin Panel, " + SessionManager.getCurrentUser().getName());
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void onAddProductsButtonClick(MouseEvent actionEvent) {
        System.out.println("Add Products button clicked");
        //Created not communicating with db yet
        mainController.showRegisterProductsPane();
    }

    public void onManageProductsButtonClick(MouseEvent actionEvent) {
        System.out.println("Manage Products button clicked");
        mainController.showManageProductsPane();
        //Create db communication later
    }

    public void onManageOrdersButtonClick(MouseEvent actionEvent) {
        System.out.println("Manage Orders button clicked");
        mainController.showManageOrdersPane();
        //not created yet
    }

    public void onManageClientsButtonClick(MouseEvent actionEvent) {
        System.out.println("Manage Clients button clicked");
        mainController.showManageClientsPane();
        //not created yet
    }

    public Node getRoot() {
        return root;
    }
}
