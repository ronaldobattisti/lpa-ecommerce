package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.OrderDAO;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.fxml.FXML;

import javafx.scene.control.*;

import java.util.Date;
import java.util.List;

public class OrdersPaneController {
    @FXML private TableView<Order> ordersTable;
    @FXML private TableColumn<Order, Integer> orderIdColumn;
    @FXML private TableColumn<Order, Date> orderDateColumn;
    @FXML private TableColumn<Order, Double> orderAmountColumn;
    @FXML private TableColumn<Order, String> paymentType;

    @FXML private TextField searchField;
    @FXML private Button refreshButton;
    @FXML private Label rowsCountLabel;

    private MainController mainController;

    public void initialize() {
        if (SessionManager.getCurrentUser() == null) {
            System.out.println("OrdersPaneController accessed without a logged-in user.");
            mainController.showProductsPane();
        }
        List<Order> orders = OrderDAO.getOrdersByUserId();



    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }
}
