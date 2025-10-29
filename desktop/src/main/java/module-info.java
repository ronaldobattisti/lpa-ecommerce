module io.github.ronaldobattisti.desktop {
    requires javafx.controls;
    requires javafx.fxml;

    requires org.controlsfx.controls;
    requires org.kordamp.bootstrapfx.core;

    opens io.github.ronaldobattisti.desktop to javafx.fxml;
    exports io.github.ronaldobattisti.desktop;
}