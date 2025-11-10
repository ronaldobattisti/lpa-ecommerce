package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.Product;
import javafx.fxml.FXML;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;

public class ProductDisplayController {

    @FXML
    private ImageView productImage;

    @FXML
    private Label productName;

    @FXML
    private Label productPrice;

    public void setProductData(Product product) {
        productName.setText(product.getName());
        productPrice.setText(String.format("AUD %.2f", product.getPrice()));

        /*try {
            //productImage.setImage(new Image(product.getImageUrl()));
            productImage.setImage(new Image(""));
        } catch (Exception e) {
            productImage.setImage(null);
        }*/
    }
}
