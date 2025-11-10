package io.github.ronaldobattisti.desktop.dao;

import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.PasswordUtils;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class UserDAO {

    public boolean loginCheck(String email, String password) throws SQLException {
        String sql = "SELECT * FROM lpa_clients WHERE lpa_client_email = ?";

        try (Connection conn = ConnectionFactory.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)){

            stmt.setString(1, email);
            ResultSet rs = stmt.executeQuery();

            if (rs.next()) {
                String storedPassword = rs.getString("lpa_client_password");
                return PasswordUtils.checkPassword(storedPassword, password);
            } else {
                throw new Exception("There is no user associated to this email");
            }
        } catch (SQLException e) {
            throw new RuntimeException("User not found");
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    public User getUser(String email,  String password) throws SQLException {
        if(loginCheck(email, password)) {
            User user = new User();

        }
    }
}
