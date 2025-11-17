package io.github.ronaldobattisti.desktop.models;

import java.util.Date;

public class User {
    private int id;
    private String firstName;
    private String lastName;
    private String name;
    private String email;
    private String password;
    private String address;
    private String phone;
    private String paymentType;
    private int cardLastFour;
    private Date registrationDate;
    private String clientStatus;
    private boolean clientGroup;

    public User(int id, String firstName, String lastName, String email, String password, String address, String phone, String paymentType, int cardLastFour, Date registrationDate, String clientStatus, boolean clientGroup) {
        this.id = id;
        this.firstName = firstName;
        this.lastName = lastName;
        this.name = firstName + " " + lastName;
        this.email = email;
        this.password = password;
        this.address = address;
        this.phone = phone;
        this.paymentType = paymentType;
        this.cardLastFour = cardLastFour;
        this.registrationDate = registrationDate;
        this.clientStatus = clientStatus;
        this.clientGroup = clientGroup;
    }

    //Registration WO payment info
    public User(String firstName, String lastName, String email, String password, String address, String phone) {
        this.firstName = firstName;
        this.lastName = lastName;
        this.name = firstName + " " + lastName;
        this.email = email;
        this.password = password;
        this.address = address;
        this.phone = phone;
    }

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

    public String getClientStatus() {
        return clientStatus;
    }

    public boolean getClientGroup() {
        return clientGroup;
    }
}
