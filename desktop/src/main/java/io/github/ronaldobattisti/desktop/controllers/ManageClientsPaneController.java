package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.UsersApiClient;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.models.User;
import io.github.ronaldobattisti.desktop.utils.SessionManager;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableRow;
import javafx.scene.control.TableView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.VBox;
import javafx.stage.Modality;
import javafx.stage.Stage;
import javafx.util.Callback;

import java.lang.classfile.constantpool.IntegerEntry;
import java.util.List;

public class ManageClientsPaneController {

    @FXML private VBox root;
    @FXML private TableView<User> userTable;
    @FXML private TableColumn<User, Integer> colClientId;
    @FXML private TableColumn<User, String> colClientFirstName;
    @FXML private TableColumn<User, String> colClientLastName;
    @FXML private TableColumn<User, String> colClientEmail;
    @FXML private TableColumn<User, String> colClientAddress;
    @FXML private TableColumn<User, String> colClientPhone;
    @FXML private TableColumn<User, String> colClientStatus;
    @FXML private TableColumn<User, String> colClientGroup;

    private MainController mainController;

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void initialize(){
        colClientId.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("id"));
        colClientFirstName.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("firstName"));
        colClientLastName.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("lastName"));
        colClientEmail.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("email"));
        colClientAddress.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("address"));
        colClientPhone.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("phone"));
        colClientStatus.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("clientStatus"));
        colClientGroup.setCellValueFactory(new javafx.scene.control.cell.PropertyValueFactory<>("clientGroup"));

        setupDoubleClick();
    }

    public void updateUserList() {
        userTable.getItems().clear();
        if (SessionManager.getCurrentUser().isAdm()){
            List<User> users = UsersApiClient.getAllUsers();
            userTable.setItems(javafx.collections.FXCollections.observableArrayList(users));
            System.out.println("ManageProductsPaneController accessed with admin privileges.");
        } else {
            System.out.println("ManageProductsPaneController accessed without admin privileges.");
            mainController.showProductsPane();
        }
    }

    public void onSearchClick(ActionEvent actionEvent) {
    }

    public void onClearClick(ActionEvent actionEvent) {
    }

    public Node getRoot() {
        return root;
    }

    private void setupDoubleClick() {
        userTable.setRowFactory(new Callback<TableView<User>, TableRow<User>>() {
            @Override
            public TableRow<User> call(TableView<User> tableView) {

                // Create each row of the table
                final TableRow<User> row = new TableRow<>();

                // Add a mouse listener to the row
                row.setOnMouseClicked(new EventHandler<MouseEvent>() {
                    @Override
                    public void handle(MouseEvent event) {

                        // Check if double-click AND row is not empty
                        if (event.getClickCount() == 2 && !row.isEmpty()) {

                            // Get the Product object of that row
                            User selectedUser = row.getItem();

                            // Open the edit window
                            if (SessionManager.getCurrentUser().isAdm()){
                                openUserEditWindow(selectedUser);
                            } else {
                                System.out.println("User not adm trying to edit orders");;
                            }
                        }
                    }
                });
                return row;
            }
        });
    }

    private void openUserEditWindow(User user){
        System.out.println("Selected user : " + user.getFirstName());

        try{
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/io/github/ronaldobattisti/desktop/components/editUserPane.fxml"));
            Parent root = loader.load();

            EditUserPaneController controller = loader.getController();

            Stage stage = new Stage();
            stage.setTitle("Editing " + user.getName() + "'s infos.");
            stage.setScene(new Scene(root));
            stage.initModality(Modality.APPLICATION_MODAL);
            controller.setUser(user);
            stage.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

}
