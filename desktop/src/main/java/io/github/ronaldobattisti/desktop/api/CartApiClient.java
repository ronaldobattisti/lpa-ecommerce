    package io.github.ronaldobattisti.desktop.api;

    import com.fasterxml.jackson.core.type.TypeReference;
    import com.fasterxml.jackson.databind.ObjectMapper;
    import io.github.ronaldobattisti.desktop.dto.CartLine;
    import io.github.ronaldobattisti.desktop.utils.SessionManager;

    import java.io.IOException;
    import java.net.URI;
    import java.net.http.HttpClient;
    import java.net.http.HttpRequest;
    import java.net.http.HttpResponse;
    import java.util.List;

    public class CartApiClient {
        private static final String API_URL = "https://www.ronaldobattisti.space/api/cart.php";
        private static final int currentUser = SessionManager.getCurrentUser().getId();

        public static List<CartLine> getItemsCart() {
            //TODO: change id call to a better logged verification
            final String API_URL_ID = API_URL + "?id=" + currentUser;

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
                                new TypeReference<List<CartLine>>() {
                                }
                        );
            } catch (Exception e) {
                throw new RuntimeException("API OrdersApiClient fail on function getItemsCart()", e);
            }
        }

        public static void deleteItemCart(int productId) {
            final String API_URL_ID = API_URL + "?user_id=" + currentUser + "&item_id=" + productId;
            HttpClient client = HttpClient.newHttpClient();
            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(API_URL_ID))
                    .DELETE()
                    .build();

            try {
                HttpResponse<String> response =
                        client.send(request, HttpResponse.BodyHandlers.ofString());

                System.out.println("Status: " + response.statusCode());
                System.out.println("Body: " + response.body());

            } catch (Exception e) {
                throw new RuntimeException("API OrdersApiClient fail on function getItemsCart()", e);
            }
        }

        public static void updateQuantityItem(int productId, int productQty) throws IOException, InterruptedException {
            //I'm sending the request with a pre-made body because otherwise I'd have to create another DTO, and I thought that unnecessary
            final String API_URL_ID = API_URL + "?user_id=" + currentUser + "&item_id=" + productId + "&product_qty=" + productQty;


            HttpRequest request = HttpRequest.newBuilder()
                    .uri(URI.create(API_URL_ID))
                    .header("Content-Type", "application/json")
                    .PUT(HttpRequest.BodyPublishers.noBody())
                    .build();

            HttpClient client = HttpClient.newHttpClient();
            HttpResponse<String> response =
                    client.send(request, HttpResponse.BodyHandlers.ofString());

            System.out.println("Status: " + response.statusCode());
            System.out.println("Body: " + response.body());
        }
    }
