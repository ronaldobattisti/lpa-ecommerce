package io.github.ronaldobattisti.desktop.controllers;

import com.gluonhq.charm.glisten.control.DropdownButton;
import io.github.ronaldobattisti.desktop.api.UploadApiClient;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.stage.FileChooser;

import java.io.File;
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;

public class AddProductsPaneController {
    @FXML private Node root;
    @FXML private TextField productName;
    @FXML private TextField productDescription;
    @FXML private TextField quantAvailable;
    @FXML private TextField productPrice;
    @FXML private DropdownButton productCategory;
    @FXML private ImageView previewImage;
    private File selectedFile;

    @FXML
    private void chooseImage() {
        FileChooser chooser = new FileChooser();

        chooser.setTitle("Select image");

        chooser.getExtensionFilters().add(
                new FileChooser.ExtensionFilter(
                        "Images", "*.png", "*.jpg", "*.jpeg", "*.webp"
                )
        );

        selectedFile = chooser.showOpenDialog(null);

        if (selectedFile != null) {
            Image img = new Image(selectedFile.toURI().toString());
            previewImage.setImage(img);

            // Call upload right after selection
            UploadApiClient.uploadImage(selectedFile);
        }
    }
}
