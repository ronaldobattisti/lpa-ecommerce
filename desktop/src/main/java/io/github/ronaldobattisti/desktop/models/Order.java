package io.github.ronaldobattisti.desktop.models;

import java.util.Date;

public class Order {
    private final int number;
    private final Date date;
    private final int clientId;
    private final double totalAmount;
    private final String paymentStatus;
    private final String invStatus;

    public Order(int number, Date date, int clientId, double totalAmount, String paymentStatus, String invStatus) {
        this.number = number;
        this.date = date;
        this.clientId = clientId;
        this.totalAmount = totalAmount;
        this.paymentStatus = paymentStatus;
        this.invStatus = invStatus;
    }

    public Order(int number, Date date, int clientId, double totalAmount) {
        this.number = number;
        this.date = date;
        this.clientId = clientId;
        this.totalAmount = totalAmount;
        this.paymentStatus = "pending";
        this.invStatus = "U";
    }

    public int getNumber() {
        return number;
    }

    public Date getDate() {
        return date;
    }

    public int getClientId() {
        return clientId;
    }

    public double getTotalAmount() {
        return totalAmount;
    }

    public String getPaymentStatus() {
        return paymentStatus;
    }

    public String getInvStatus() {
        return invStatus;
    }

}
