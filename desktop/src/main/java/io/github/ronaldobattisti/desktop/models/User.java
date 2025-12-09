package io.github.ronaldobattisti.desktop.models;

import com.fasterxml.jackson.annotation.JsonProperty;
//used to parse date format from JSON
import com.fasterxml.jackson.annotation.JsonFormat;
import java.util.Date;

public class User {
    @JsonProperty("lpa_client_id")
    private int id;

    @JsonProperty("lpa_client_firstname")
    private String firstName;

    @JsonProperty("lpa_client_lastname")
    private String lastName;
    private String name;

    @JsonProperty("lpa_client_email")
    private String email;

    @JsonProperty("lpa_client_password")
    private String password;

    @JsonProperty("lpa_client_address")
    private String address;

    @JsonProperty("lpa_client_phone")
    private String phone;

    @JsonProperty("lpa_client_payment_type")
    private String paymentType;

    @JsonProperty("lpa_client_card_last4")
    private int cardLastFour;

    @JsonProperty("lpa_client_registered")
    @JsonFormat(pattern = "yyyy-MM-dd HH:mm:ss")
    private Date registrationDate;

    @JsonProperty("lpa_client_status")
    private String clientStatus;

    @JsonProperty("lpa_client_group")
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
        this.email = email;
        this.password = password;
        this.address = address;
        this.phone = phone;
    }

    public User() {
        //Constructor required by Jackson
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
        return firstName + " " + lastName;
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

    public boolean isAdm() {
        return clientGroup;
    }
}
