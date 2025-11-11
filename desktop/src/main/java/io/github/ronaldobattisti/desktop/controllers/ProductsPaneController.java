package io.github.ronaldobattisti.desktop.controllers;

import javafx.fxml.FXML;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.FlowPane;

public class ProductsPaneController {

    @FXML private AnchorPane root; // root container
    @FXML private FlowPane productContainer;

    private MainController mainController;

    // Called automatically after FXML loads
    @FXML
    private void initialize() {
        System.out.println("Products pane initialized");
    }

    // This allows MainController to inject itself
    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    // So MainController can bring this pane to front
    public AnchorPane getRoot() {
        return root;
    }

    // Example: dynamically populate products
    public void loadProducts() {
        productContainer.getChildren().clear();

        // Example placeholder content
        for (int i = 1; i <= 10; i++) {
            javafx.scene.control.Label label = new javafx.scene.control.Label("Product " + i);
            label.setStyle("-fx-border-color: gray; -fx-padding: 10;");
            productContainer.getChildren().add(label);
        }
    }
}
