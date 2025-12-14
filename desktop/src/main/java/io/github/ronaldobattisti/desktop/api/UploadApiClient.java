package io.github.ronaldobattisti.desktop.api;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;

import java.io.File;
import java.io.IOException;
import java.net.URI;
import java.net.http.HttpClient;
import java.net.http.HttpRequest;
import java.net.http.HttpResponse;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;

public class UploadApiClient {

    private static final String API_URL =
            "https://ronaldobattisti.space/api/upload.php";


    //TODO: replace all code below by http injection with apache
    public static String uploadImage(File file) {
        String imageUrl = null;
        try {
            String boundary = "----JavaFXBoundary" + System.nanoTime();

            HttpClient client = HttpClient.newHttpClient();

            // Build HTTP request
            HttpRequest request =
                    HttpRequest.newBuilder()
                            .uri(new URI(API_URL)) // API URL
                            .header("Content-Type",
                                    "multipart/form-data; boundary=" + boundary)
                            .POST(buildMultipartBody(file.toPath(), boundary)) // Attach body to POST request
                            .build();

            // Send request synchronously and capture response
            HttpResponse<String> response =
                    client.send(
                            request,
                            HttpResponse.BodyHandlers.ofString()
                    );
            String json = response.body();
            System.out.println("API response: " + json);

            ObjectMapper mapper = new ObjectMapper();
            JsonNode root = mapper.readTree(json);

            boolean success = root.get("success").asBoolean();

            if (!success) {
                System.err.println("Upload failed: " + root.get("error").asText());
                return null;
            }

            imageUrl = root.get("url").asText();

            // Return PHP JSON response

        } catch (Exception e) {
            e.printStackTrace();
        }
        return imageUrl;
    }

//I have no idea what's going on here
    private static HttpRequest.BodyPublisher buildMultipartBody(
            Path file, String boundary) throws IOException {

        var byteArrays = new ArrayList<byte[]>();

        // ---- Start boundary ----
        byteArrays.add((
                "--" + boundary + "\r\n"
        ).getBytes(StandardCharsets.UTF_8));

        // ---- Headers for this part ----
        byteArrays.add((
                "Content-Disposition: form-data; name=\"image\"; filename=\"" +
                        file.getFileName() + "\"\r\n" +
                        "Content-Type: application/octet-stream\r\n\r\n"
        ).getBytes(StandardCharsets.UTF_8));

        // ---- Actual binary file ----
        byteArrays.add(Files.readAllBytes(file));

        // ---- Newline after file ----
        byteArrays.add("\r\n".getBytes(StandardCharsets.UTF_8));

        // ---- Closing boundary ----
        byteArrays.add((
                "--" + boundary + "--"
        ).getBytes(StandardCharsets.UTF_8));

        // Join all segments
        return HttpRequest.BodyPublishers.ofByteArrays(byteArrays);
    }
}
