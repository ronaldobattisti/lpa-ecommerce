package io.github.ronaldobattisti.desktop.models;

import com.fasterxml.jackson.annotation.JsonProperty;

public class Product {
    @JsonProperty("lpa_stock_id")
    private int id;

    @JsonProperty("lpa_stock_name")
    private String name;

    @JsonProperty("lpa_stock_desc")
    private String description;

    @JsonProperty("lpa_stock_onhand")
    private int stockOnhand;

    @JsonProperty("lpa_stock_price")
    private double price;

    @JsonProperty("lpa_stock_cat")
    private String category;

    @JsonProperty("lpa_stock_image")
    private String imageUrl;

    @JsonProperty("lpa_stock_status")
    private String status;

    public Product(int id, String name, String description, int stockOnhand, double price, String category, String imageUrl, String status) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.stockOnhand = stockOnhand;
        this.price = price;
        this.category = category;
        this.imageUrl = imageUrl;
        this.status = status;
    }

    public Product() {
        //Default constructor required by Jackson
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setName(String name) {
        this.name = name;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setStockOnhand(int stockOnhand) {
        this.stockOnhand = stockOnhand;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    public void setCategory(String category) {
        this.category = category;
    }

    public void setImageUrl(String imageUrl) {
        this.imageUrl = imageUrl;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getName() {
        return name;
    }

    public String getDescription() {
        return description;
    }

    public int getStockOnhand() {
        return stockOnhand;
    }

    public double getPrice() {
        return price;
    }

    public String getCategory() {
        return category;
    }

    public String getImageUrl() {
        return imageUrl;
    }

    public String getStatus() {
        return status;
    }
}
