package io.github.ronaldobattisti.desktop.dao;

import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.PasswordUtils;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class UserDAO {

    public User loginCheck(String email, String password) throws SQLException {
        String sql = "SELECT * FROM lpa_clients WHERE lpa_client_email = ?";

        try (Connection conn = ConnectionFactory.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)){

            stmt.setString(1, email);
            ResultSet rs = stmt.executeQuery();

            if (rs.next()) {
                String storedPassword = rs.getString("lpa_client_password");
                if (PasswordUtils.checkPassword(storedPassword, password)){
                    System.out.println("Password Match");
                    //return rs;
                    return new User(rs.getInt("lpa_client_id"),
                            rs.getString("lpa_client_firstname"),
                            rs.getString("lpa_client_lastname"),
                            email,
                            password,
                            rs.getString("lpa_client_address"),
                            rs.getString("lpa_client_phone"),
                            rs.getString("lpa_client_payment_type"),
                            rs.getInt("lpa_client_card_last4"),
                            rs.getDate("lpa_client_registered"),
                            rs.getString("lpa_client_status"),
                            rs.getBoolean("lpa_client_group"));
                } else {
                    throw new Exception("Wrong password");
                }
            } else {
                throw new Exception("There is no user associated to this email");
            }
        } catch (Exception e) {
            throw new SQLException(e);
        }
    }
}
