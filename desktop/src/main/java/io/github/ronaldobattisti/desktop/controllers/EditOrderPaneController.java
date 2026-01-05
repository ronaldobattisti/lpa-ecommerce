package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.OrdersApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

public class EditOrderPaneController {
    @FXML private VBox root;
    @FXML private TextField invoiceNumberField;
    @FXML private TextField clientNameField;
    @FXML private TextField invoiceDateField;
    @FXML private TextField invoiceTotaValueField;
    @FXML private ComboBox paymentComboBox;
    @FXML private ComboBox orderStatusComboBox;

    MainController mainController;
    private Order order;

    public void initialize (){}

    public void onCancel(ActionEvent actionEvent) {
        Stage stage = (Stage) ((Node) actionEvent.getSource()).getScene().getWindow();
        stage.close();
    }

    public void setOrder(Order order) {
        try {
            this.order = order;
            invoiceNumberField.setText(String.valueOf(order.getId()));
            clientNameField.setText(String.valueOf(order.getClientName()));
            invoiceDateField.setText(String.valueOf(order.getDate()));
            invoiceTotaValueField.setText(String.valueOf(order.getAmount()));
            paymentComboBox.getSelectionModel().select(order.getStatus());
            orderStatusComboBox.getSelectionModel().select(order.getInvStatus());
        } catch (Exception e) {
            System.err.println("EditOrderPaneController: failed to populate fields");
            e.printStackTrace();
        }
    }

    public void onUpdate(ActionEvent actionEvent) throws Exception {
        double amount = Double.parseDouble(invoiceTotaValueField.getText());
        String status = paymentComboBox.getSelectionModel().getSelectedItem().toString();
        String invStatus = orderStatusComboBox.getSelectionModel().getSelectedItem().toString();

        this.order.setAmount(amount);
        this.order.setStatus(status);
        this.order.setInvStatus(invStatus);

        OrdersApiClient.updateOrders(this.order);
    }
}
