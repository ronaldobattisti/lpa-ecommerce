package io.github.ronaldobattisti.desktop.controllers;

import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.layout.Region;
import javafx.scene.layout.StackPane;

import java.util.List;

public class MainController {

    @FXML private HeaderController headerIncludeController;
    @FXML private LoginPaneController loginPaneIncludeController;
    @FXML private ProductsPaneController productsPaneIncludeController;
    @FXML private RegisterPaneController registerPaneIncludeController;
    @FXML private LoggedPaneController loggedPaneIncludeController;
    @FXML private OrdersPaneController ordersPaneIncludeController;
    @FXML private StackPane contentArea;

    @FXML
    private void initialize() {
        // Inject back reference
        headerIncludeController.setMainController(this);
        loginPaneIncludeController.setMainController(this);
        productsPaneIncludeController.setMainController(this);
        registerPaneIncludeController.setMainController(this);
        loggedPaneIncludeController.setMainController(this);
        ordersPaneIncludeController.setMainController(this);

        //binding all the panes at the same time
        List<Node> panes = List.of(
            loginPaneIncludeController.getRoot(),
            productsPaneIncludeController.getRoot(),
            registerPaneIncludeController.getRoot(),
            loggedPaneIncludeController.getRoot(),
            ordersPaneIncludeController.getRoot()
        );

        // Start with products pane visible (others hidden)
        for (Node node : panes) {
            bindPane(node);
        }

        showPane(productsPaneIncludeController.getRoot());
    }

    private void bindPane(Node node) {
        Region region = (Region)node;
        region.prefWidthProperty().bind(contentArea.widthProperty());
        region.prefHeightProperty().bind(contentArea.heightProperty());
    }

    private void showPane(Node root) {
        for (Node node : contentArea.getChildren()) {
            if (node == root) {
                node.setVisible(true);
                node.setManaged(true);
            } else {
                node.setVisible(false);
                node.setManaged(false);
            }
        }
    }

    public void showLoginPane() {
        showPane((Node) loginPaneIncludeController.getRoot());
    }

    public void showProductsPane() {
        showPane((Node) productsPaneIncludeController.getRoot());
    }

    public void showRegisterPane() {
        showPane((Node) registerPaneIncludeController.getRoot());
    }

    public void showLoggedPane() {
        showPane((Node) loggedPaneIncludeController.getRoot());
        loggedPaneIncludeController.refresh();
    }

    public void showOrdersPane() {
        ordersPaneIncludeController.updateOrdersTable();
        showPane((Node) ordersPaneIncludeController.getRoot());
    }

    public void updateHeader() {
        headerIncludeController.update();
    }
}
