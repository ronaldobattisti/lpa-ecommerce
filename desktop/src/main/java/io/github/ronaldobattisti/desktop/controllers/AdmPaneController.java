package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
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
    public void initialize() {
    }

    public void update(){
        welcomeLabel.setText("Welcome to the Admin Panel, " + SessionManager.getCurrentUser().getName());
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void onAddProductsButtonClick(MouseEvent actionEvent) {
        System.out.println("Add Products button clicked");
        mainController.showAddProductPane();
    }

    public void onManageProductsButtonClick(MouseEvent actionEvent) {
        System.out.println("Manage Products button clicked");
    }

    public void onManageOrdersButtonClick(MouseEvent actionEvent) {
        System.out.println("Manage Orders button clicked");
    }

    public void onManageClientsButtonClick(MouseEvent actionEvent) {
        System.out.println("Manage Clients button clicked");
    }

    public Node getRoot() {
        return root;
    }
}
