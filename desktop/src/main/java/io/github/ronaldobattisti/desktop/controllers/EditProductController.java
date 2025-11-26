package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.Product;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;

public class EditProductController {

    @FXML TextField idField;
    @FXML TextField nameField;
    @FXML TextField descriptionField;
    @FXML TextField priceField;
    @FXML TextField qtyField;
    @FXML ComboBox<String> categoryBox;
    @FXML TextField imagePathField;

    private Product product;

    public void setProduct(Product product) {
        this.product = product;
        // Populate UI controls if they have been injected
        try {
            if (idField != null && product != null) {
                idField.setText(String.valueOf(product.getId()));
            }
            if (nameField != null && product != null) {
                nameField.setText(product.getName());
            }
            if (descriptionField != null && product != null) {
                descriptionField.setText(product.getDescription());
            }
            if (priceField != null && product != null) {
                priceField.setText(String.valueOf(product.getPrice()));
            }
            if (qtyField != null && product != null) {
                // Product exposes stockOnhand via getStockOnhand()
                qtyField.setText(String.valueOf(product.getStockOnhand()));
            }
            if (categoryBox != null && product != null && product.getCategory() != null) {
                // try to select the category if present in the combobox
                categoryBox.getSelectionModel().select(product.getCategory());
            }
            if (imagePathField != null && product != null) {
                // Product stores the image as imageUrl
                imagePathField.setText(product.getImageUrl());
            }
        } catch (Exception e) {
            // avoid breaking initialization for unexpected nulls or getters
            System.err.println("EditProductController: failed to populate fields: " + e.getMessage());
            e.printStackTrace();
        }
    }

    public void onChooseFile(ActionEvent actionEvent) {
    }

    public void onCancel(ActionEvent actionEvent) {
    }

    public void onUpdate(ActionEvent actionEvent) {
    }
}
