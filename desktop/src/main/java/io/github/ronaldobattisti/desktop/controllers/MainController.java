package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.ProductsApiClient;
import io.github.ronaldobattisti.desktop.api.UsersApiClient;
import io.github.ronaldobattisti.desktop.models.Product;
import io.github.ronaldobattisti.desktop.models.User;
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
    @FXML private AdmPaneController admPaneIncludeController;
    @FXML private RegisterProductsPaneController registerProductsPaneIncludeController;
    @FXML private ManageProductsPaneController manageProductsPaneIncludeController;
    @FXML private ManageOdersPaneController manageOrdersPaneIncludeController;
    @FXML private ManageClientsPaneController manageClientsPaneIncludeController;

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
        admPaneIncludeController.setMainController(this);
        registerProductsPaneIncludeController.setMainController(this);
        manageProductsPaneIncludeController.setMainController(this);
        manageOrdersPaneIncludeController.setMainController(this);
        manageClientsPaneIncludeController.setMainController(this);

        //binding all the panes at the same time
        List<Node> panes = List.of(
            loginPaneIncludeController.getRoot(),
            productsPaneIncludeController.getRoot(),
            registerPaneIncludeController.getRoot(),
            loggedPaneIncludeController.getRoot(),
            ordersPaneIncludeController.getRoot(),
            admPaneIncludeController.getRoot(),
            registerProductsPaneIncludeController.getRoot(),
            manageProductsPaneIncludeController.getRoot(),
            manageOrdersPaneIncludeController.getRoot(),
            manageClientsPaneIncludeController.getRoot()
        );

        // Start with products pane visible (others hidden)
        for (Node node : panes) {
            bindPane(node);
        }

        List<User> users = UsersApiClient.getAllUsers();

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

    //I'm casting to Node to avoid issues with different return types
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

    public void showAdmPane() {
        admPaneIncludeController.update();
        showPane((Node) admPaneIncludeController.getRoot());
    }

    public void showAddProductPane() {
        showPane((Node) registerProductsPaneIncludeController.getRoot());
    }

    public void showManageProductsPane() {
        manageProductsPaneIncludeController.updateProductsList();
        showPane((Node) manageProductsPaneIncludeController.getRoot());
    }

    public void showManageOrdersPane() {
        manageOrdersPaneIncludeController.updateOrdersList();
        showPane((Node) manageOrdersPaneIncludeController.getRoot());
    }

    public void showManageClientsPane() {
        manageClientsPaneIncludeController.updateClientsList();
        showPane((Node) manageClientsPaneIncludeController.getRoot());
    }

    public void updateHeader() {
        headerIncludeController.update();
    }



}
