package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.OrderDAO;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;

import javafx.scene.control.*;
import javafx.scene.layout.VBox;

import java.sql.SQLException;
import java.util.Date;
import java.util.List;

public class OrdersPaneController {
    @FXML private TableView<Order> ordersTable;
    @FXML private TableColumn<Order, Integer> orderIdColumn;
    @FXML private TableColumn<Order, Date> orderDateColumn;
    @FXML private TableColumn<Order, Double> orderAmountColumn;
    @FXML private TableColumn<Order, String> paymentStatusColumn;

    @FXML private VBox root;

    @FXML private TextField searchField;
    @FXML private Button refreshButton;
    @FXML private Label rowsCountLabel;


    private MainController mainController;

    public void initialize() {
        orderIdColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("id"));
        orderDateColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("date"));
        orderAmountColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("amount"));
        paymentStatusColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("status"));
    }

    public void updateOrdersTable() {
        try {
            ordersTable.getItems().clear();
            if (SessionManager.getCurrentUser() == null) {
                System.out.println("OrdersPaneController accessed without a logged-in user.");
                mainController.showProductsPane();
            } else {
                int userId = SessionManager.getCurrentUser().getId();
                List<Order> orders = OrderDAO.getOrdersByUserId(userId);
                //Convert List to ObservableList to display in TableView
                ordersTable.setItems(FXCollections.observableArrayList(orders));
            }
        } catch (SQLException e){
            System.out.println("Error fetching orders: " + e.getMessage());
        }
    }

    public VBox getRoot() {
        return root;
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }
}
