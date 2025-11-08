package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.Product;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.control.ScrollPane;

public class MainController {
    @FXML
    private ProductsPaneController productsPaneController;

    @FXML
    private FXMLLoader productsPaneLoader;

    @FXML
    private ScrollPane scrollPane;

    @FXML
    private void initialize() {
        // Get the nested controller dynamically
        FXMLLoader loader = new FXMLLoader(getClass().getResource(
                "/io/github/ronaldobattisti/desktop/components/products_pane.fxml"
        ));
        try {
            loader.load();
            ProductsPaneController productsController = loader.getController();

            // Bind FlowPane responsiveness to ScrollPane width
            /*scrollPane.viewportBoundsProperty().addListener((obs, oldVal, newVal) -> {
                productsController.updateWrapWidth(newVal.getWidth() - 40);
            });*/

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
