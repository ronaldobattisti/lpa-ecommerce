package io.github.ronaldobattisti.desktop.app;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.io.IOException;

public class MainApplication extends Application {
    @Override
    public void start(Stage stage) throws IOException {
        FXMLLoader fxmlLoader = new FXMLLoader(
                getClass().getResource("/io/github/ronaldobattisti/desktop/main.fxml")
        );
        Scene scene = new Scene(fxmlLoader.load(), 320, 240);
        stage.setTitle("LPA Online Store");
        stage.setScene(scene);
        stage.show();
    }
}
