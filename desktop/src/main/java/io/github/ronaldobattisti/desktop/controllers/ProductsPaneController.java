package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.ProductsApiClient;
import io.github.ronaldobattisti.desktop.models.Product;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.layout.FlowPane;
import javafx.scene.layout.HBox;
import java.io.IOException;
import java.util.List;

public class ProductsPaneController {

    @FXML private HBox root;
    @FXML private FlowPane productContainer;

    private MainController mainController;

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

        List<Product> products = ProductsApiClient.getAllProducts();
        displayProducts(products);
    }

    // This allows MainController to inject itself
    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void updateProductsDisplay(){
        productContainer.getChildren().clear();
        List<Product> products = ProductsApiClient.getAllProducts();
        displayProducts(products);
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

    // So MainController can bring this pane to front
    public HBox getRoot() {
        return root;
    }
}
