package io.github.ronaldobattisti.desktop.dao;

import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import io.github.ronaldobattisti.desktop.models.Product;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class ProductDAO {

    public List<Product> getAllProducts() throws SQLException {
        return getProductsByCategory(null);
    }

    public List<Product> getProductsByCategory(String category) throws SQLException {

        List<Product> products = new ArrayList<>();
        String sql;

        if (category == null || category.isEmpty()){
            sql = "SELECT * FROM lpa_stock";
        } else {
            sql = "SELECT * FROM lpa_stock WHERE category = ?";
        }

        try(Connection conn = ConnectionFactory.getConnection();
            PreparedStatement stmt = conn.prepareStatement(sql)){

            if (category != null && !category.isEmpty()) {
                stmt.setString(1, category);
            }

            //ResultSet is an iterator(cursor)
            ResultSet rs = stmt.executeQuery();

            while(rs.next()) {
                Product p = new Product(
                        rs.getInt("lpa_stock_id"),
                        rs.getString("lpa_stock_name"),
                        rs.getString("lpa_stock_desc"),
                        rs.getInt("lpa_stock_onhand"),
                        rs.getDouble("lpa_stock_price"),
                        rs.getString("lpa_stock_cat"),
                        rs.getString("lpa_stock_image"),
                        rs.getString("lpa_stock_status")
                );
                products.add(p);
            }

        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
        return products;
    }
}
