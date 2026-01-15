package io.github.ronaldobattisti.desktop.controllers;

import io.github.ronaldobattisti.desktop.api.UsersApiClient;
import io.github.ronaldobattisti.desktop.dto.UserUpdateRequest;
import io.github.ronaldobattisti.desktop.models.User;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

public class EditUserPaneController {
    @FXML private VBox root;
    @FXML private TextField clientIdField;
    @FXML private TextField clientGroupField;
    @FXML private TextField clientFirstNameField;
    @FXML private TextField clientLastNameField;
    @FXML private TextField clientEmailField;
    @FXML private TextField clientAddressField;
    @FXML private ComboBox clientStatusComboBox;

    private User user;

    MainController mainController;

    public Node getRoot (){
        return root;
    }

    public void setMainController(MainController mainController) {
        this.mainController = mainController;
    }

    public void onCancel(ActionEvent actionEvent) {
        Stage stage = (Stage) ((Node) actionEvent.getSource()).getScene().getWindow();
        stage.close();
    }

    public void setUser(User user) {
        try {
            this.user = user;
            clientIdField.setText(String.valueOf(user.getId()));
            clientGroupField.setText(String.valueOf(String.valueOf(user.isAdm())));
            clientFirstNameField.setText(String.valueOf(user.getFirstName()));
            clientLastNameField.setText(String.valueOf(user.getLastName()));
            clientEmailField.setText(String.valueOf(user.getEmail()));
            clientAddressField.setText(String.valueOf(user.getAddress()));

            clientStatusComboBox.getSelectionModel().select(user.getClientStatus());

        } catch (Exception e) {
            System.err.println("EditOrderPaneController: failed to populate fields");
            e.printStackTrace();
        }
    }

    public void onUpdate(ActionEvent actionEvent) throws Exception {
        System.out.println("updating users table");
        int id = Integer.parseInt(clientIdField.getText());
        String group = clientGroupField.getText();
        String firstName = clientFirstNameField.getText();
        String lastName = clientLastNameField.getText();
        String adress = clientAddressField.getText();
        String clientStatus = clientStatusComboBox.getSelectionModel().getSelectedItem().toString();

        UserUpdateRequest user = new UserUpdateRequest(id, group, firstName, lastName, adress, clientStatus);

        UsersApiClient.updateUser(user);
    }
}
