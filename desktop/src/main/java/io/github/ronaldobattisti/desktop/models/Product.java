package io.github.ronaldobattisti.desktop.models;

import com.fasterxml.jackson.annotation.JsonProperty;
import javafx.beans.property.IntegerProperty;
import javafx.beans.property.SimpleIntegerProperty;

public class Product {
    @JsonProperty("prodId")
    private int id;

    @JsonProperty("prodName")
    private String name;

    @JsonProperty("prodDesc")
    private String description;

    @JsonProperty("prodStock")
    private int stockOnhand;

    @JsonProperty("prodPrice")
    private double price;

    @JsonProperty("prodCat")
    private String category;

    @JsonProperty("prodImage")
    private String imageUrl;

    @JsonProperty("prodStatus")
    private String status;

    public Product(int id,
                   String name,
                   String description,
                   int stockOnhand,
                   double price,
                   String category,
                   String imageUrl,
                   String status) {
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
