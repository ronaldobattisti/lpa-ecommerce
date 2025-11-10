package io.github.ronaldobattisti.desktop.utils;

import org.mindrot.jbcrypt.BCrypt;

public class PasswordUtils {

    public static boolean checkPassword(String storedPassword, String inputtedPassword) {

        // Fix for PHP-generated hashes
        if (storedPassword.startsWith("$2y$")) {
            storedPassword = "$2a$" + storedPassword.substring(4);
        }

        try {
            //Has to be in this order: plainPassword, hashedPassword
            return BCrypt.checkpw(inputtedPassword, storedPassword);
        } catch (IllegalArgumentException e) {
            // Log to verify what prefix reached here if it ever fails again
            System.err.println("Hash prefix problem: " + storedPassword);
            throw new RuntimeException("Password verification failed", e);
        }
    }

}
