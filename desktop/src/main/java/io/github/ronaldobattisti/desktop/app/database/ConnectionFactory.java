package io.github.ronaldobattisti.desktop.app.database;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionFactory {
    private static final String URL = "jdbc:mysql://localhost:3306/lpa_ecomms";
    private static final String USERNAME = "root";
    private static final String PASSWORD = "";

    //prevent instantiation
    private ConnectionFactory() {}

    //Returns a new DB connection
    //Must close() after use
    public static Connection getConnection() {
        try {
            return DriverManager.getConnection(URL, USERNAME, PASSWORD);
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
    }

    public static void closeConnection(Connection conn) {
        if (conn != null) {
            try {
                conn.close();
            } catch (SQLException _) {}
        }
    }
}
