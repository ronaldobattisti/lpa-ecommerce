package io.github.ronaldobattisti.desktop.controllers;

import com.sun.tools.javac.Main;
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
    }

    public void initialize() {
        System.out.println("EditProductController initialized with item: " + product.getName());
    }

    public void onChooseFile(ActionEvent actionEvent) {
    }

    public void onCancel(ActionEvent actionEvent) {
    }

    public void onUpdate(ActionEvent actionEvent) {
    }
}
