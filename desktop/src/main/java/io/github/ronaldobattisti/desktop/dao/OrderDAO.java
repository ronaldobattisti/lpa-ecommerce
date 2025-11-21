package io.github.ronaldobattisti.desktop.dao;

import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.models.Product;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class OrderDAO {
    public List<Order> getAllOrders() throws SQLException {
        return getOrdersByUserId(null);
    }

    public List<Order> getOrdersByUserId(String category) throws SQLException {

        List<Order> orders = new ArrayList<>();
        String sql;

        if (category == null || category.isEmpty()){
            sql = "SELECT * FROM lpa_invoices";
        } else {
            sql = "SELECT * FROM lpa_invoices WHERE lpa_inv_client_id = ?";
        }

        try(Connection conn = ConnectionFactory.getConnection();
            PreparedStatement stmt = conn.prepareStatement(sql)){

            if (category != null && !category.isEmpty()) {
                stmt.setString(1, category);
            }

            //ResultSet is an iterator(cursor)
            ResultSet rs = stmt.executeQuery();

            while(rs.next()) {
                Order o = new Order(
                        rs.getInt("lpa_inv_no"),
                        rs.getDate("lpa_inv_date"),
                        rs.getInt("lpa_inv_client_id "),
                        rs.getDouble("lpa_inv_amount"),
                        rs.getString("lpa_inv_payment_type"),
                        rs.getString("lpa_inv_status")
                );
                orders.add(o);
            }

        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
        return orders;
    }
}
