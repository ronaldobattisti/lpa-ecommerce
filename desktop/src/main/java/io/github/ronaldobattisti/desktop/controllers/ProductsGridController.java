package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.ProductDAO;
import io.github.ronaldobattisti.desktop.models.Product;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.control.Label;
import javafx.scene.layout.GridPane;

import java.io.IOException;
import java.sql.SQLException;
import java.util.List;

public class ProductsGridController {

    @FXML
    private GridPane productGrid;

    private final ProductDAO productDAO = new ProductDAO();

    public void initialize() {
        try {
            List<Product> products = productDAO.getAllProducts();
            populateGrid(products);
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
    }

    private void populateGrid(List<Product> products) {
        int column = 0;
        int row = 0;

        for (Product product : products) {
            try {
                FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/product_display.fxml"));
                //It only works if the fxml file defines a controller
                Node productDisplay = loader.load();

                ProductDisplayController controller = loader.getController();
                controller.setProductData(product);

                productGrid.add(productDisplay, column, row);

                column++;

                if (column == 4) {
                    column = 0;
                    row++;
                }

            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }


}
