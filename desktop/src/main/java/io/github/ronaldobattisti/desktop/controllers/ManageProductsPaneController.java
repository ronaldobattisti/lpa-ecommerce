package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.ProductDAO;
import io.github.ronaldobattisti.desktop.models.Product;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.layout.VBox;

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
            List<Product> products = ProductDAO.getAllProducts();

        } catch (SQLException e) {
            System.out.println("Error fetching products: " + e.getMessage());
        }



    }
}
