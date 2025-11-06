package io.github.ronaldobattisti.desktop.models;

public class Product {
    private int id;
    private String name;
    private String description;
    private int stockOnhand;
    private float price;
    private String category;
    private String imageUrl;
    private String status;

    public Product(int id, String name, String description, int stockOnhand, float price, String category, String imageUrl, String status) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.stockOnhand = stockOnhand;
        this.price = price;
        this.category = category;
        this.imageUrl = imageUrl;
        this.status = status;
    }

    public int getId() {
        return id;
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

    public float getPrice() {
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
