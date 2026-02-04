package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.CartApiClient;
import io.github.ronaldobattisti.desktop.models.Product;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.fxml.FXML;
import javafx.scene.Parent;
import javafx.scene.layout.HBox;

import java.util.ArrayList;
import java.util.List;

public class CartPaneController {
    @FXML HBox root;

    private MainController mainController;

    public static void updateCart() {
        List<Product> products = new ArrayList<Product>();

        if (SessionManager.getCurrentUser() != null){
            products = CartApiClient.getItemsCart();
        } else {
            throw new RuntimeException("User might be logged to access the cart");
        }
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Parent getRoot(){
        return root;
    }
}
