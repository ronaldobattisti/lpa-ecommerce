package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.ProductDAO;
import io.github.ronaldobattisti.desktop.models.Product;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.FlowPane;
import javafx.scene.layout.HBox;

import java.io.IOException;
import java.sql.SQLException;
import java.util.List;

public class ProductsPaneController {

    @FXML private HBox root;
    @FXML private FlowPane productContainer;

    private MainController mainController;

    private final ProductDAO productDAO = new ProductDAO();

    // Called automatically after FXML loads
    @FXML
    private void initialize() {
        productContainer.sceneProperty().addListener((obs, oldScene, newScene) -> {
            if (newScene != null) {
                newScene.widthProperty().addListener((o, oldW, newW) -> {
                    double availableWidth = newW.doubleValue() - 80; // small padding adjustment
                    productContainer.setPrefWrapLength(availableWidth);
                });
            }
        });

        try {
            List<Product> products = productDAO.getAllProducts();
            displayProducts(products);
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
    }

    private void displayProducts(List<Product> products) {
        for (Product product : products) {
            try {
                FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/productDisplay.fxml"));
                Node productDisplay = loader.load();

                ProductDisplayController controller = loader.getController();
                controller.setProductData(product);
                productContainer.getChildren().add(productDisplay);

            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    /*public void updateWrapWidth(double width) {
        productContainer.setPrefWrapLength(width);
    }*/



    // This allows MainController to inject itself
    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    // So MainController can bring this pane to front
    public HBox getRoot() {
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
