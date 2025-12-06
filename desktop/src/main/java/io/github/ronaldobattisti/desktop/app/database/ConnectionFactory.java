package io.github.ronaldobattisti.desktop.app.database;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class ConnectionFactory {
    private static final String DB_HOST = "sql303.infinityfree.com";
    private static final String DB_NAME = "if0_40513248_lpa_ecomms";
    private static final String DB_USER = "if0_40513248";
    private static final String DB_PASS = "Rb19962025";

    private static final String URL =
            "jdbc:mysql://" + DB_HOST + ":3306/" + DB_NAME +
            "?useSSL=false&serverTimezone=UTC";

    //Returns a new DB connection
    //Must close() after use
    public static Connection getConnection() {
        try {
            return DriverManager.getConnection(URL, DB_USER, DB_PASS);
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
