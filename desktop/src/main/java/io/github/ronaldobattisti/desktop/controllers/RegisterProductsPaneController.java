package io.github.ronaldobattisti.desktop.controllers;

import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.*;
import javafx.stage.FileChooser;
import javafx.stage.Window;

import java.io.File;
import java.math.BigDecimal;

public class RegisterProductsPaneController {

    @FXML private Node root;
    @FXML private TextField productNameField;
    @FXML private TextArea productDescriptionArea;
    @FXML private TextField quantityField;
    @FXML private TextField priceField;
    @FXML private ComboBox<String> categoryComboBox;
    @FXML private TextField imagePathField;
    @FXML private Button selectImageButton;
    @FXML private Button registerButton;

    private MainController mainController;

    @FXML
    public void initialize() {
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    @FXML
    private void onSelectImage() {
        FileChooser chooser = new FileChooser();
        chooser.setTitle("Select product image");
        chooser.getExtensionFilters().addAll(
            new FileChooser.ExtensionFilter("Image Files", "*.png", "*.jpg", "*.jpeg", "*.gif")
        );
        Window window = selectImageButton.getScene().getWindow();
        File file = chooser.showOpenDialog(window);
        if (file != null) {
            imagePathField.setText(file.toURI().toString());
        }
    }

    @FXML
    private void onRegisterProduct() {
        String name = productNameField.getText();
        String desc = productDescriptionArea.getText();
        String qtyText = quantityField.getText();
        String priceText = priceField.getText();
        String category = categoryComboBox.getValue();
        String image = imagePathField.getText();

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

        // TODO: persist the product via DAO
        showAlert("Success", "Product registered successfully (not really persisted in this example).");
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

