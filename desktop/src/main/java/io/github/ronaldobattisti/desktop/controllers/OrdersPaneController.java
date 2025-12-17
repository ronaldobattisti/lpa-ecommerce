package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.OrdersApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.collections.FXCollections;
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

    @FXML
    private Label welcomeLabel;

    private MainController mainController;

    public void initialize() {
        orderIdColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("id"));
        orderDateColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("date"));
        orderAmountColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("amount"));
        paymentStatusColumn.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("status"));

        // Acessar welcomeLabel apenas aqui (após injeção)
        if (welcomeLabel != null) {
            // exemplo mínimo: garantir texto inicial
            welcomeLabel.setText("Pedidos");
        }
    }

    public void updateOrdersTable() {
        try {
            ordersTable.getItems().clear();
            Boolean userIsAdm = SessionManager.getCurrentUser().isAdm();
            int userId = SessionManager.getCurrentUser().getId();

            if (SessionManager.getCurrentUser() != null) {
                if (userIsAdm) {
                    List<Order> orders = OrdersApiClient.getAllOrders();
                    //Convert List to ObservableList to display in TableView
                    ordersTable.setItems(FXCollections.observableArrayList(orders));
                } else {
                    List<Order> orders = OrdersApiClient.getOrdersById(userId);
                    //Convert List to ObservableList to display in TableView
                    ordersTable.setItems(FXCollections.observableArrayList(orders));
                }
            } else {
                System.out.println("OrdersPaneController accessed without a logged-in user.");
                mainController.showProductsPane();
            }
        } catch (RuntimeException e){
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
