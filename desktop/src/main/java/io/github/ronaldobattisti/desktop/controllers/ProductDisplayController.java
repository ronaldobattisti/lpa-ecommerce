package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.dao.ProductDAO;
import javafx.fxml.FXML;
import javafx.scene.control.Label;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

public class ProductDisplayController {

    @FXML
    private Label productLabel;

    public void initialize(){
        productLabel.setText(printAllProducts());
    }


}
