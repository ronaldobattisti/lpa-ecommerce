package io.github.ronaldobattisti.desktop.api;

import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.util.List;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.core.type.TypeReference;
import io.github.ronaldobattisti.desktop.dto.UserUpdateRequest;
import io.github.ronaldobattisti.desktop.models.User;

public class UsersApiClient {
    private static final String API_URL =
            "https://www.ronaldobattisti.space/api/user.php";

    public static List<User> getAllUsers() {
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
                            new TypeReference<List<User>>() {}
                    );
        } catch (Exception e) {
            throw new RuntimeException("API call failed", e);
        }
    }

    public static User getUserByEmail(String email) {
        final String API_URL_EMAIL = API_URL + "?email=" + email.replace("@", "%40");
        HttpClient client = HttpClient.newHttpClient();
        HttpRequest request = HttpRequest.newBuilder()
                .uri(URI.create(API_URL_EMAIL))
                .GET()
                .build();
        try {
            HttpResponse<String> response =
                    client.send(request, HttpResponse.BodyHandlers.ofString());
            return new ObjectMapper()
                    .readValue(
                            response.body(),
                            new TypeReference<User>() {}
                    );
        } catch (Exception e) {
            throw new RuntimeException("API call failed", e);
        }
    }

    public static void updateUser(UserUpdateRequest user) throws Exception {
        ObjectMapper mapper = new ObjectMapper();
        String json = mapper.writeValueAsString(user);

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
