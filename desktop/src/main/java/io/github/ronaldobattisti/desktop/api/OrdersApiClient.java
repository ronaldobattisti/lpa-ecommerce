package io.github.ronaldobattisti.desktop.api;

import com.fasterxml.jackson.core.type.TypeReference;
import com.fasterxml.jackson.databind.ObjectMapper;
import io.github.ronaldobattisti.desktop.models.Order;
import io.github.ronaldobattisti.desktop.models.Product;

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

    public static List<Order> getOrdersById(int id) {

        final String API_URL_ID = API_URL + "?id=" + id;

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
                            new TypeReference<List<Order>>() {
                            }
                    );
        } catch (Exception e) {
            throw new RuntimeException("API OrdersApiClient fail on function getOrdersById()");
        }
    }

    public static void updateOrders(Order order) throws Exception {
        ObjectMapper mapper = new ObjectMapper();
        String json = mapper.writeValueAsString(order);

        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(API_URL))
                .header("Content-Type", "application/json")
                .PUT(HttpRequest.BodyPublishers.ofString(json))
                .build();

        HttpClient client = HttpClient.newHttpClient();
        HttpResponse<String> response =
                client.send(request, HttpResponse.BodyHandlers.ofString());

        System.out.println("Status: " + response.statusCode());
        System.out.println("Body: " + response.body());
    }
}
