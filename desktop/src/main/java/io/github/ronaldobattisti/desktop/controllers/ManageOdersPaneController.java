package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.OrdersApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableRow;
import javafx.scene.control.TableView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.VBox;
import javafx.stage.Modality;
import javafx.stage.Stage;
import javafx.util.Callback;

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

        setupDoubleClick();
    }

    public void updateOrdersList() {
        orderTable.getItems().clear();
        if (SessionManager.getCurrentUser().isAdm()){
            List<Order> orders = OrdersApiClient.getAllOrders();
            orderTable.setItems(javafx.collections.FXCollections.observableArrayList(orders));
            System.out.println("ManageProductsPaneController accessed with admin privileges.");
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

    private void setupDoubleClick() {
        orderTable.setRowFactory(new Callback<TableView<Order>, TableRow<Order>>() {
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
                                System.out.println("User not adm trying to edit orders");;
                            }
                        }
                    }
                });
                return row;
            }
        });
    }

    private void openOrderEditWindow(Order order) {
        System.out.println("Double-clicked on order: " + order.getId());

        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/editOrderPane.fxml"));
            Parent root = loader.load();

            EditOrderPaneController controller = loader.getController();
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
}
