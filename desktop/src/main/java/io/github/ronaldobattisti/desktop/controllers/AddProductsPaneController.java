package io.github.ronaldobattisti.desktop.controllers;

import com.gluonhq.charm.glisten.control.DropdownButton;
import io.github.ronaldobattisti.desktop.api.UploadApiClient;
import io.github.ronaldobattisti.desktop.models.Product;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.scene.Node;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.stage.FileChooser;
import java.io.File;

public class AddProductsPaneController {
    @FXML private Node root;
    @FXML private TextField productNameField;
    @FXML private TextField productDescriptionField;
    @FXML private TextField quantAvailableField;
    @FXML private TextField productPriceField;
    @FXML private DropdownButton productCategoryButton;
    @FXML private ImageView previewImage;

    private Product prod = new Product();

    @FXML
    private void chooseImage() {
        FileChooser chooser = new FileChooser();

        chooser.setTitle("Select image");

        chooser.getExtensionFilters().add(
                new FileChooser.ExtensionFilter(
                        "Images", "*.png", "*.jpg", "*.jpeg", "*.webp"
                )
        );

        File selectedFile = chooser.showOpenDialog(null);

        if (selectedFile != null) {
            Image img = new Image(selectedFile.toURI().toString());
            previewImage.setImage(img);

            // Call upload right after selection
            String url = UploadApiClient.uploadImage(selectedFile);

            if (url == null || url.isBlank()) {
                // show alert
                System.err.println("Image upload failed");
                return;
            }

            prod.setImageUrl(url);
        }
    }

    public void registerProduct(ActionEvent actionEvent) {
        //try{
            String productName = productNameField.getText();
            prod.setName(productName);
            String productDescription = productDescriptionField.getText();
            prod.setDescription(productDescription);
            int quantAvailable = Integer.parseInt(quantAvailableField.getText());
            prod.setStockOnhand(quantAvailable);
            double productPrice = Double.parseDouble(productPriceField.getText());
            prod.setPrice(productPrice);
            String productCategory = String.valueOf(productCategoryButton.getSelectedItem());
            prod.setCategory(productCategory);
            System.out.println('a');
        //} catch (NumberFormatException e){
        //    System.out.println("Error: " + e);
        //}

    }
}
