package io.github.ronaldobattisti.desktop.dto;

import io.github.ronaldobattisti.desktop.models.Product;

public class CartLine {
    private Product product;
    private int quantity;

    public CartLine() {}

    public CartLine(Product product, int quantity) {
        this.product = product;
        this.quantity = quantity;
    }

    public Product getProduct() {
        return product;
    }

    public void setProduct(Product product) {
        this.product = product;
    }

    public int getQuantity() {
        return quantity;
    }
    public void setQuantity(int quantity) {
        this.quantity = quantity;
    }
}
