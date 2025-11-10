package io.github.ronaldobattisti.desktop.models;

import java.util.Date;

public class User {
    private int id;
    private String firstName;
    private String lastName;
    private String name = firstName + " " + lastName;
    private String email;
    private String password;
    private String address;
    private String phone;
    private String paymentType;
    private int cardLastFour;
    private Date registrationDate;
    private char clientStatus;
    private boolean clientGroup;

    public int getId() {
        return id;
    }

    public String getFirstName() {
        return firstName;
    }

    public String getLastName() {
        return lastName;
    }

    public String getName() {
        return name;
    }

    public String getEmail() {
        return email;
    }

    public String getPassword() {
        return password;
    }

    public String getAddress() {
        return address;
    }

    public String getPhone() {
        return phone;
    }

    public String getPaymentType() {
        return paymentType;
    }

    public int getCardLastFour() {
        return cardLastFour;
    }

    public Date getRegistrationDate() {
        return registrationDate;
    }

    public char getClientStatus() {
        return clientStatus;
    }

    public boolean isClientGroup() {
        return clientGroup;
    }
}
