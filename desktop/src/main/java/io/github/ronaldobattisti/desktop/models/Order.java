package io.github.ronaldobattisti.desktop.models;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;

import java.util.Date;

public class Order {
    //@JsonProperty("lpa_stock_id")
    private final int id;

    //@JsonProperty("")
    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
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
