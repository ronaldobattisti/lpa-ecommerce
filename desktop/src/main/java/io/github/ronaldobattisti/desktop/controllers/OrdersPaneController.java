package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.OrdersApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.collections.FXCollections;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.VBox;
import javafx.stage.Modality;
import javafx.stage.Stage;
import javafx.util.Callback;

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

    public VBox getRoot() {
        return root;
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

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

    private void setupDoubleClick() {
        ordersTable.setRowFactory(new Callback<TableView<Order>, TableRow<Order>>() {
            @Override
            public TableRow<Order> call(TableView<Order> tableView) {

                // Create each row of the table
                final TableRow<Order> row = new TableRow<>();

                // Add a mouse listener to the row
                row.setOnMouseClicked(new EventHandler<MouseEvent>() {
                    @Override
                    public void handle(MouseEvent event) {

                        // Check if double-click AND row is not empty
                        if (event.getClickCount() == 2 && !row.isEmpty()) {

                            // Get the Product object of that row
                            Order selectedOrder = row.getItem();

                            // Open the edit window
                            if (SessionManager.getCurrentUser().isAdm()){
                                openOrderEditWindow(selectedOrder);
                            } else {
                                openOrderVisualizationWindow(selectedOrder);
                            }
                        }
                    }
                });
                return row;
            }
        });
    }

    //TODO: create FXML for modal order edit
    private void openOrderEditWindow(Order order) {
        System.out.println("Double-clicked on order: " + order.getId());

        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/editProductPane.fxml"));
            Parent root = loader.load();

            EditProductController controller = loader.getController();
            //controller.setProduct(product);

            Stage stage = new Stage();
            stage.setTitle("Edit Order - " + order.getId());
            stage.setScene(new Scene(root));
            stage.initModality(Modality.APPLICATION_MODAL);
            controller.setOrder(order);
            stage.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    //TODO: Implement all (FXML + controller +
    private void openOrderVisualizationWindow(Order order) {
        /*System.out.println("Double-clicked on order: " + order.getId());

        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/editProductPane.fxml"));
            Parent root = loader.load();

            EditProductController controller = loader.getController();
            //controller.setProduct(product);

            Stage stage = new Stage();
            stage.setTitle("Edit Order - " + order.getId());
            stage.setScene(new Scene(root));
            stage.initModality(Modality.APPLICATION_MODAL);
            controller.setOrder(order);
            stage.show();
        } catch (Exception e) {
            e.printStackTrace();
        }*/
    }
}
