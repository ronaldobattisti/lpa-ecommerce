package io.github.ronaldobattisti.desktop.controllers;

import com.fasterxml.jackson.annotation.JsonProperty;
import io.github.ronaldobattisti.desktop.api.ProductsApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.models.Product;
import io.github.ronaldobattisti.desktop.utils.ProductImageSelector;
import javafx.beans.property.IntegerProperty;
import javafx.beans.property.SimpleIntegerProperty;
import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

public class EditProductController {

    @FXML TextField idField;
    @FXML TextField nameField;
    @FXML TextField descriptionField;
    @FXML TextField priceField;
    @FXML TextField qtyField;
    @FXML ComboBox<String> categoryBox;
    @FXML TextField imagePathField;

    private Product prod;

    public void initialize(){

    }

    public void setProduct(Product product) {
        this.prod = product;
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
        String url = ProductImageSelector.SelectImage();
        imagePathField.setText(url);
    }

    public void onCancel(ActionEvent actionEvent) {
        Stage stage = (Stage) ((Node) actionEvent.getSource()).getScene().getWindow();
        stage.close();
    }

    public void onUpdate(ActionEvent actionEvent) {
        //TODO:triggers the API products with put request
        try{
            prod.setName(nameField.getText());
            prod.setDescription(descriptionField.getText());
            prod.setPrice(Double.parseDouble(priceField.getText()));
            prod.setStockOnhand(Integer.parseInt(qtyField.getText()));
            prod.setCategory(categoryBox.getValue());
            prod.setImageUrl(imagePathField.getText());

            ProductsApiClient.updateProducts(prod);
        } catch (RuntimeException e){
            System.out.println("Error: " + e);
        } catch (Exception e) {
            throw new RuntimeException(e);
        }

        System.out.println("end");
    }

    public void setOrder(Order order) {

    }
}
