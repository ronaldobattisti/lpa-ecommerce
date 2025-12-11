package io.github.ronaldobattisti.desktop.models;

import com.fasterxml.jackson.annotation.JsonFormat;
import com.fasterxml.jackson.annotation.JsonProperty;

import java.util.Date;

public class Order {
    @JsonProperty("lpa_inv_no")
    private int id;
    @JsonProperty("lpa_inv_date")
    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private Date date;
    @JsonProperty("lpa_inv_client_id")
    private int clientId;
    @JsonProperty("lpa_inv_amount")
    private double amount;
    @JsonProperty("lpa_inv_payment_type")
    private String status;
    @JsonProperty("lpa_inv_status")
    private String invStatus;
    @JsonProperty("lpa_client_firstname")
    private String clientFirstName;
    @JsonProperty("lpa_client_lastname")
    private String clientLastName;

    private String clientName;

    public Order(int id, Date date, int clientId, double amount, String status, String invStatus, String clientFirstName, String clientLastName) {
        this.id = id;
        this.date = date;
        this.clientId = clientId;
        this.amount = amount;
        this.status = status;
        this.invStatus = invStatus;
        this.clientFirstName = clientFirstName;
        this.clientLastName = clientLastName;
    }

    public Order(int id, Date date, int clientId, double amount) {
        this.id = id;
        this.date = date;
        this.clientId = clientId;
        this.amount = amount;
        this.status = "pending";
        this.invStatus = "U";
    }

    public Order() {
        //Default constructor required for JSON parsing
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

    public String getClientName(){
        return clientFirstName + " " + clientLastName;
    }

    public void setClientLastName(String clientLastName) {
        this.clientLastName = clientLastName;
    }

    public void setClientFirstName(String clientFirstName) {
        this.clientFirstName = clientFirstName;
    }

    public void setInvStatus(String invStatus) {
        this.invStatus = invStatus;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public void setAmount(double amount) {
        this.amount = amount;
    }

    public void setClientId(int clientId) {
        this.clientId = clientId;
    }

    public void setDate(Date date) {
        this.date = date;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getClientFirstName() {
        return clientFirstName;
    }

    public String getClientLastName() {
        return clientLastName;
    }
}
