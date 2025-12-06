package io.github.ronaldobattisti.desktop.dao;

import com.google.gson.Gson;
import com.google.gson.reflect.TypeToken;
import io.github.ronaldobattisti.desktop.app.database.ConnectionFactory;
import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.PasswordUtils;

import java.lang.reflect.Type;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.List;

public class UserDAO {

    private static final String API_URL = "https://ecomms.wuaze.com/api/users.php";


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

    public void registerNewUser(User user) throws SQLException {
        String sql = "INSERT INTO lpa_clients (lpa_client_firstname, lpa_client_lastname, lpa_client_email, lpa_client_password, lpa_client_address, lpa_client_phone) VALUES (?, ?, ?, ?, ?, ?)";

        String hashedPassword = PasswordUtils.hashPassword(user.getPassword());

        try (Connection conn = ConnectionFactory.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {

            stmt.setString(1, user.getFirstName());
            stmt.setString(2, user.getLastName());
            stmt.setString(3, user.getEmail());
            stmt.setString(4, hashedPassword);
            stmt.setString(5, user.getAddress());
            stmt.setString(6, user.getPhone());

            stmt.executeUpdate();
        } catch (SQLException e) {
            throw new SQLException("Error registering new user: " + e.getMessage());
        }
    }

    public boolean checkEmailExists(User user) throws SQLException {
        return false;
    }

    public static List<User> getAllUsers() {
        try {
            HttpURLConnection con =
                    (HttpURLConnection) new URL(API_URL).openConnection();

            con.setRequestMethod("GET");

            // Read JSON response
            String json =
                    new String(con.getInputStream().readAllBytes());

            // Convert JSON → Java Objects
            Type listType =
                    new TypeToken<List<User>>() {}.getType();

            List<User> users = new Gson().fromJson(json, listType);

            return users;

        } catch (Exception e) {
            throw new RuntimeException("Failed to fetch users", e);
        }
    }
}
