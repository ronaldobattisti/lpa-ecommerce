package io.github.ronaldobattisti.desktop.utils;

import io.github.ronaldobattisti.desktop.models.User;

public class SessionManager {
    private static User currentUser;

    private SessionManager() {
        // Private constructor to prevent instantiation
    }

    public static void setCurrentUser(User user) {
        currentUser = user;
    }

    public static User getCurrentUser() {
        return currentUser;
    }

    public static void logout() {
        setCurrentUser(null);
    }
}
