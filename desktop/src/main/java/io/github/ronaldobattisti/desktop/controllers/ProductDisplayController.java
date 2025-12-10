package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.Product;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;

public class ProductDisplayController {

    @FXML private ImageView productImage;
    @FXML private Label productName;
    @FXML private Label productPrice;

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

    //TODO: Implement button visibility
    /*@FXML
    public void setButtonUsable(){
    }*/

}
