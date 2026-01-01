package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.models.Order;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;
import javafx.scene.layout.VBox;

public class EditOrderPaneController {
    @FXML private VBox root;
    @FXML private TextField invoiceNumberField;
    @FXML private TextField clientNameField;
    @FXML private TextField invoiceDateField;
    @FXML private TextField invoiceTotaValueField;
    @FXML private ComboBox paymentComboBox;
    @FXML private ComboBox orderStatusComboBox;


    MainController mainController;

    public void initialize (){}

    public void onCancel(ActionEvent actionEvent) {
    }

    public void onUpdate(ActionEvent actionEvent) {
    }

    public void setOrder(Order order) {
        invoiceNumberField.setText(String.valueOf(order.getId()));
        clientNameField.setText(String.valueOf(order.getClientName()));
        invoiceDateField.setText(String.valueOf(order.getDate()));
        invoiceTotaValueField.setText(String.valueOf(order.getAmount()));
    }
}
