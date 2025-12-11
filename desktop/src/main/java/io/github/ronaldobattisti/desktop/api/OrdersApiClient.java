package io.github.ronaldobattisti.desktop.api;

import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.ObjectMapper;
import io.github.ronaldobattisti.desktop.models.Order;
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.util.List;

public class OrdersApiClient {
    private static final String API_URL =
            "https://www.ronaldobattisti.space/api/order.php";

    public static List<Order> getAllOrders() {
        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(API_URL))
                .GET()
                .build();
        try {
            HttpResponse<String> response =
                    client.send(request, HttpResponse.BodyHandlers.ofString());
            return new ObjectMapper()
                    .readValue(
                            response.body(),
                            new TypeReference<List<Order>>() {}
                    );
        } catch (Exception e) {
            throw new RuntimeException("API call failed", e);
        }
    }
}
