package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.CartApiClient;
import io.github.ronaldobattisti.desktop.dto.CartLine;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.beans.property.ReadOnlyObjectWrapper;
import javafx.fxml.FXML;
import javafx.scene.Parent;
import javafx.scene.control.*;
import javafx.scene.layout.HBox;

import java.util.ArrayList;
import java.util.List;

public class CartPaneController {
    @FXML HBox root;

    @FXML private TableView<CartLine> cartTable;
    @FXML private TableColumn<CartLine, Number> colId;
    @FXML private TableColumn<CartLine, String> colName;
    @FXML private TableColumn<CartLine, Number> colQty;

    private MainController mainController;

    public void initialize(){
        colId.setCellValueFactory(data ->
                new ReadOnlyObjectWrapper<>(
                        data.getValue().getProduct().getId()
                )
        );

        colName.setCellValueFactory(data ->
                new ReadOnlyObjectWrapper<>(
                        data.getValue().getProduct().getName()
                )
        );

        colQty.setCellValueFactory(data ->
                new ReadOnlyObjectWrapper<>(
                        data.getValue().getQuantity()
                )
        );

        ///
        colQty.setCellFactory(col -> new TableCell<CartLine, Number>() {
            private final Button minus = new Button("-");
            private final Label qtyLabel = new Label();
            private final Button plus = new Button("+");
            private final HBox box = new HBox(8, minus, qtyLabel, plus);

            {
                box.getStyleClass().add("qty-box");
                minus.getStyleClass().add("qty-btn");
                plus.getStyleClass().add("qty-btn");
                qtyLabel.getStyleClass().add("qty-label");

                minus.setFocusTraversable(false);
                plus.setFocusTraversable(false);
            }

            @Override
            protected void updateItem(Number item, boolean empty) {
                super.updateItem(item, empty);

                if (empty) {
                    setGraphic(null);
                    return;
                }

                CartLine line = getTableView().getItems().get(getIndex());
                qtyLabel.setText(String.valueOf(line.getQuantity()));

                minus.setDisable(line.getQuantity() <= 1);

                minus.setOnAction(e -> {
                    line.setQuantity(line.getQuantity() - 1);
                    getTableView().refresh();
                    // TODO: call API to update quantity (optional for now)
                });

                plus.setOnAction(e -> {
                    line.setQuantity(line.getQuantity() + 1);
                    getTableView().refresh();
                    // TODO: call API to update quantity
                });

                setGraphic(box);
            }
        });
        ///

    }

    public void updateCart() {
        List<CartLine> cartItems = new ArrayList<CartLine>();

        if (SessionManager.getCurrentUser() != null){
            cartItems = CartApiClient.getItemsCart();
            System.out.println(cartItems.toString());
            cartTable.getItems().setAll(cartItems);
        } else {
            throw new RuntimeException("User might be logged to access the cart");
        }
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public Parent getRoot(){
        return root;
    }
}
