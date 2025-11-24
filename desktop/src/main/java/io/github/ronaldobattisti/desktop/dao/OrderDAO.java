package io.github.ronaldobattisti.desktop.dao;

import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import io.github.ronaldobattisti.desktop.models.Order;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class OrderDAO {

    public static List<Order> getOrdersByUserId(int userId) throws SQLException {

        List<Order> orders = new ArrayList<>();
        String sql = "SELECT * FROM lpa_invoices WHERE lpa_inv_client_id = ?";

        try(Connection conn = ConnectionFactory.getConnection();
            PreparedStatement stmt = conn.prepareStatement(sql)){

            stmt.setInt(1, userId);

            ResultSet rs = stmt.executeQuery();

            while(rs.next()) {
                Order o = new Order(
                        rs.getInt("lpa_inv_no"),
                        rs.getDate("lpa_inv_date"),
                        rs.getInt("lpa_inv_client_id"),
                        rs.getDouble("lpa_inv_amount"),
                        rs.getString("lpa_inv_payment_type"),
                        rs.getString("lpa_inv_status")
                );
                orders.add(o);
            }

        } catch (RuntimeException e) {
            System.out.println("Error fetching orders for user ID " + userId + ": " + e.getMessage());
        }
        return orders;
    }
}
