package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.Product;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;

public class ProductDisplayController {

    @FXML private ImageView productImage;
    @FXML private Label productName;
    @FXML private Label productPrice;
    @FXML private Button addToCartButton;
    @FXML private Node root;
    private MainController mainController;

    public Node getRoot() {
        return root;
    }

    public void setProductData(Product product) {
        productName.setText(product.getName());
        productPrice.setText(String.format("AUD %.2f", product.getPrice()));
        Image image = new Image(product.getImageUrl(), true);
        productImage.setImage(image);
    }

    @FXML
    private void onAddToCart(ActionEvent actionEvent) {
        System.out.println("Add to cart clicked for product: " + productName.getText());
    }

    @FXML
    public void enableAddToCartButton() {
        //addToCartButton.setDisable(false);
        addToCartButton.setVisible(true);
        addToCartButton.setManaged(true);
    }

    @FXML
    public void disableAddToCartButton() {
        //addToCartButton.setDisable(true);
       addToCartButton.setVisible(false);
       addToCartButton.setManaged(false);
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

}
