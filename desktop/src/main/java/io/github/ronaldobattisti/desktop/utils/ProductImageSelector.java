package io.github.ronaldobattisti.desktop.utils;

import io.github.ronaldobattisti.desktop.api.UploadApiClient;
import javafx.scene.image.Image;
import javafx.stage.FileChooser;

import java.io.File;

//Used to open a pop-up to select an image,
//send this image to the web folder with a unique fileName
//and retuning its url
public class ProductImageSelector {

    public static String SelectImage(){
        FileChooser chooser = new FileChooser();
        String url = null;

        chooser.setTitle("Select image");

        chooser.getExtensionFilters().add(
                new FileChooser.ExtensionFilter(
                        "Images", "*.png", "*.jpg", "*.jpeg", "*.webp"
                )
        );

        File selectedFile = chooser.showOpenDialog(null);

        if (selectedFile != null) {
            Image img = new Image(selectedFile.toURI().toString());
            //previewImage.setImage(img);

            // Call upload right after selection
            url = UploadApiClient.uploadImage(selectedFile);

            if (url == null || url.isBlank()) {
                // show alert
                System.err.println("Image upload failed");
            }
        }
        return url;
    }
}
