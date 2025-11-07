package io.github.ronaldobattisti.desktop.models;

public class Product {
    private int id;
    private String name;
    private String description;
    private int stockOnhand;
    private double price;
    private String category;
    private String imageUrl;
    private String status;

    public Product(int id, String name, String description, int stockOnhand, double price, String category, String imageUrl, String status) {
        this.id = id;
        this.name = name;
        this.description = description;
        this.stockOnhand = stockOnhand;
        this.price = price;
        this.category = category;
        imageUrl = imageUrl.substring(imageUrl.lastIndexOf('/') + 1);//get only the file name
        imageUrl = "/resources/images/" + imageUrl;
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
