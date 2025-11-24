package io.github.ronaldobattisti.desktop.models;

import java.util.Date;

public class Order {
    private final int id;
    private final Date date;
    private final int clientId;
    private final double amount;
    private final String status;
    private final String invStatus;

    public Order(int id, Date date, int clientId, double amount, String status, String invStatus) {
        this.id = id;
        this.date = date;
        this.clientId = clientId;
        this.amount = amount;
        this.status = status;
        this.invStatus = invStatus;
    }

    public Order(int id, Date date, int clientId, double amount) {
        this.id = id;
        this.date = date;
        this.clientId = clientId;
        this.amount = amount;
        this.status = "pending";
        this.invStatus = "U";
    }

    public int getId() {
        return id;
    }

    public Date getDate() {
        return date;
    }

    public int getClientId() {
        return clientId;
    }

    public double getAmount() {
        return amount;
    }

    public String getStatus() {
        return status;
    }

    public String getInvStatus() {
        return invStatus;
    }

}
