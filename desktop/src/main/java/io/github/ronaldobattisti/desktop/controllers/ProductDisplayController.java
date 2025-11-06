package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import javafx.fxml.FXML;
import javafx.scene.control.Label;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class ProductDisplayController {

    @FXML
    private Label productLabel;

    public void initialize(){
        productLabel.setText(printAllProducts());
    }

    public String printAllProducts(){
        String sql = "SELECT * FROM lpa_stock";
        StringBuilder productLabel = new StringBuilder();

        try(Connection conn = ConnectionFactory.getConnection();
            PreparedStatement stmt = conn.prepareStatement(sql);
            ResultSet rs = stmt.executeQuery();) {

            while(rs.next()) {
                System.out.println(rs.getString("lpa_stock_name"));
                productLabel.append(rs.getString("lpa_stock_name"));
            }

        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
        return productLabel.toString();
    }
}
