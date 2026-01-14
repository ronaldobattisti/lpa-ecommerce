package io.github.ronaldobattisti.desktop.dto;

import com.fasterxml.jackson.annotation.JsonProperty;

public class InvoiceUpdateRequest {
    @JsonProperty("id")
    private int id;

    @JsonProperty("amount")
    private double amount;

    @JsonProperty("status")
    private String paymentType;

    @JsonProperty("invStatus")
    private String invoiceStatus;

    public InvoiceUpdateRequest(int id, double amount, String paymentType, String invoiceStatus) {
        this.id = id;
        this.amount = amount;
        this.paymentType = paymentType;
        this.invoiceStatus = invoiceStatus;
    }

    public int getId() {
        return id;
    }

    public double getAmount() {
        return amount;
    }

    public String getPaymentType() {
        return paymentType;
    }

    public String getInvoiceStatus() {
        return invoiceStatus;
    }
}
