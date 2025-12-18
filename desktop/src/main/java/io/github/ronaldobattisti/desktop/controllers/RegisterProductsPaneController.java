package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.ProductsApiClient;
import io.github.ronaldobattisti.desktop.models.Product;
import io.github.ronaldobattisti.desktop.utils.ProductImageSelector;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.*;
import java.math.BigDecimal;

public class RegisterProductsPaneController {

    @FXML private Node root;
    @FXML private TextField productNameField;
    @FXML private TextArea productDescriptionArea;
    @FXML private TextField quantityField;
    @FXML private TextField priceField;
    @FXML private ComboBox<String> categoryComboBox;
    @FXML private TextField imagePathField;

    private MainController mainController;

    Product prod = new Product();

    @FXML
    public void initialize() {
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    @FXML
    private void onSelectImage() {
        String url = ProductImageSelector.SelectImage();
        prod.setImageUrl(url);
        imagePathField.setText(url);
    }

    @FXML
    private void onRegisterProduct() {
        String name = productNameField.getText();
        String desc = productDescriptionArea.getText();
        String qtyText = quantityField.getText();
        String priceText = priceField.getText();
        String category = categoryComboBox.getValue();


        // Very simple validation
        if (name == null || name.isBlank()) {
            showAlert("Validation", "Product name is required.");
            return;
        }

        int qty = 0;
        try {
            qty = Integer.parseInt(qtyText);
            if (qty < 0) throw new NumberFormatException();
        } catch (Exception e) {
            showAlert("Validation", "Quantity must be a non-negative integer.");
            return;
        }

        BigDecimal price;
        try {
            price = new BigDecimal(priceText);
            if (price.compareTo(BigDecimal.ZERO) < 0) throw new NumberFormatException();
        } catch (Exception e) {
            showAlert("Validation", "Price must be a non-negative number.");
            return;
        }

        if (category == null || category.isBlank()) {
            showAlert("Validation", "Please select a category.");
            return;
        }

        prod.setName(productNameField.getText());
        prod.setDescription(productDescriptionArea.getText());
        prod.setCategory(categoryComboBox.getValue());
        prod.setStockOnhand(Integer.parseInt(quantityField.getText()));
        prod.setPrice(Double.parseDouble(priceField.getText()));

        try{
            ProductsApiClient.registerProduct(prod);
        } catch (Exception e) {
            throw new RuntimeException(e);
        }

        // TODO: persist the product via DAO
        showAlert("Success", "Product registered successfully");
        clearForm();
    }

    private void clearForm() {
        productNameField.clear();
        productDescriptionArea.clear();
        quantityField.clear();
        priceField.clear();
        categoryComboBox.getSelectionModel().clearSelection();
        imagePathField.clear();
    }

    private void showAlert(String title, String msg) {
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle(title);
        alert.setHeaderText(null);
        alert.setContentText(msg);
        alert.showAndWait();
    }

    public Node getRoot() {
        return root;
    }
}

