package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.OrdersApiClient;
import io.github.ronaldobattisti.desktop.api.ProductsApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.models.Product;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.layout.VBox;

import java.util.List;

public class ManageOdersPaneController {

    @FXML private VBox root;

    @FXML private TableView<Order> orderTable;
    @FXML private TableColumn<Order, Integer> colInvId;
    @FXML private TableColumn<Order,String> colCostumerName;
    @FXML private TableColumn<Order, String> colDate;
    @FXML private TableColumn<Order, Double> colAmount;
    @FXML private TableColumn<Order, String> colPaymentStatus;

    private MainController mainController;

    public void initialize() {
        colInvId.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("id"));
        colCostumerName.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("clientName"));
        colDate.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("date"));
        colAmount.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("amount"));
        colPaymentStatus.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("status"));
    }

    public void updateOrdersList() {
        orderTable.getItems().clear();
        if (SessionManager.getCurrentUser().isAdm()){
            List<Order> orders = OrdersApiClient.getAllOrders();
            orderTable.setItems(javafx.collections.FXCollections.observableArrayList(orders));
        } else {
            System.out.println("ManageProductsPaneController accessed without admin privileges.");
            mainController.showProductsPane();
        }

    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Node getRoot() {
        return (Node) root;
    }

    public void onSearchClick(ActionEvent actionEvent) {
    }

    public void onClearClick(ActionEvent actionEvent) {
    }
}
