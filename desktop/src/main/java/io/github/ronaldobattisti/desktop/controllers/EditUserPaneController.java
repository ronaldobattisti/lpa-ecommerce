package io.github.ronaldobattisti.desktop.controllers;

import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

public class EditUserPaneController {
    @FXML private VBox root;
    @FXML private TextField invoiceNumberField;
    @FXML private TextField clientNameField;
    @FXML private TextField invoiceDateField;
    @FXML private TextField invoiceTotaValueField;
    @FXML private ComboBox paymentComboBox;
    @FXML private ComboBox orderStatusComboBox;

    MainController mainController;

    public Node getRoot (){
        return root;
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }


    public void onCancel(ActionEvent actionEvent) {
        Stage stage = (Stage) ((Node) actionEvent.getSource()).getScene().getWindow();
        mainController.updateOrdersAdmTable();
        stage.close();
    }

    public void setUser(Order order) {
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
        int id = Integer.parseInt(invoiceNumberField.getText());
        double amount = Double.parseDouble(invoiceTotaValueField.getText());
        String status = paymentComboBox.getSelectionModel().getSelectedItem().toString();
        String invStatus = orderStatusComboBox.getSelectionModel().getSelectedItem().toString();

        InvoiceUpdateRequest order = new InvoiceUpdateRequest(id, amount, status, invStatus);

        OrdersApiClient.updateOrders(order);
    }
}
