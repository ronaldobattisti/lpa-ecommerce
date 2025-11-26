package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.ProductDAO;
import io.github.ronaldobattisti.desktop.models.Product;
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

import java.sql.SQLException;
import java.util.List;

public class ManageProductsPaneController {

    @FXML VBox root;

    @FXML private TableView<Product> productTable;
    @FXML private TableColumn<Product, Integer> colId;
    @FXML private TableColumn<Product, String> colName;
    @FXML private TableColumn<Product, Double> colPrice;
    @FXML private TableColumn<Product, Integer> colQty;

    private MainController mainController;

    public void initialize() {
        colId.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("id"));
        colName.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("name"));
        colPrice.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("price"));
        colQty.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("stockOnhand"));

        setupDoubleClick();
    }

    public ManageProductsPaneController() {
        // must exist (even empty)
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Node getRoot() {
        return root;
    }

    public void onSearchClick(ActionEvent actionEvent) {
        System.out.println("Search button clicked in ManageProductsPaneController");
    }

    public void onClearClick(ActionEvent actionEvent) {
        System.out.println("Clear button clicked in ManageProductsPaneController");
    }

    public void updateProductsList() {
        try{
            productTable.getItems().clear();
            if (SessionManager.getCurrentUser().isAdm()){
                List<Product> products = ProductDAO.getAllProducts();
                productTable.setItems(javafx.collections.FXCollections.observableArrayList(products));
            } else {
                System.out.println("ManageProductsPaneController accessed without admin privileges.");
                mainController.showProductsPane();
            }
        } catch (SQLException e) {
            System.out.println("Error fetching products: " + e.getMessage());
        }
    }

    private void setupDoubleClick() {
        productTable.setRowFactory(new Callback<TableView<Product>, TableRow<Product>>() {
            @Override
            public TableRow<Product> call(TableView<Product> tableView) {

                // Create each row of the table
                final TableRow<Product> row = new TableRow<>();

                // Add a mouse listener to the row
                row.setOnMouseClicked(new EventHandler<MouseEvent>() {
                    @Override
                    public void handle(MouseEvent event) {

                        // Check if double-click AND row is not empty
                        if (event.getClickCount() == 2 && !row.isEmpty()) {

                            // Get the Product object of that row
                            Product selectedProduct = row.getItem();

                            // Open the edit window
                            openEditWindow(selectedProduct);
                        }
                    }
                });
                return row;
            }
        });
    }

    private void openEditWindow(Product product) {
        System.out.println("Double-clicked on product: " + product.getName());

        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/editProductPane.fxml"));
            Parent root = loader.load();

            EditProductController controller = loader.getController();
            controller.setProduct(product);

            Stage stage = new Stage();
            stage.setTitle("Edit Product - " + product.getName());
            stage.setScene(new Scene(root));
            stage.initModality(Modality.APPLICATION_MODAL);
            stage.show();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
