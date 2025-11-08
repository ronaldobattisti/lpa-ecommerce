package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.ProductDAO;
import io.github.ronaldobattisti.desktop.models.Product;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.layout.FlowPane;

import java.awt.*;
import java.io.IOException;
import java.sql.SQLException;
import java.util.List;

public class ProductsPaneController {

    @FXML
    private FlowPane productContainer;

    @FXML
    private ScrollPane scrollPane;

    private final ProductDAO productDAO = new ProductDAO();

    public void initialize() {

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
                FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/product_display.fxml"));
                //It only works if the fxml file defines a controller
                Node productDisplay = loader.load();

                ProductDisplayController controller = loader.getController();
                controller.setProductData(product);

                productContainer.getChildren().add(productDisplay);

            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }


    public void updateWrapWidth(double width) {
        productContainer.setPrefWrapLength(width);
    }
}
