package io.github.ronaldobattisti.desktop.api;

import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.ObjectMapper;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.models.Product;
import io.github.ronaldobattisti.desktop.utils.SessionManager;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.util.List;

public class CartApiClient {
    private static final String API_URL = "https://www.ronaldobattisti.space/api/cart.php";

    public static List<Product> getItemsCart() {
        //TODO: change id call to a better logged verification
        final String API_URL_ID = API_URL + "?id=" + SessionManager.getCurrentUser().getId();

        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(API_URL_ID))
                .GET()
                .build();

        try {
            HttpResponse<String> response =
                    client.send(request, HttpResponse.BodyHandlers.ofString());

            System.out.println("Status: " + response.statusCode());
            System.out.println("Body: " + response.body());

            return new ObjectMapper()
                    .readValue(
                            response.body(),
                            new TypeReference<List<Product>>() {
                            }
                    );
        } catch (Exception e) {
            throw new RuntimeException("API OrdersApiClient fail on function getOrdersById()");
        }
    }
}
