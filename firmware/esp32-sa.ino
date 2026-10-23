#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "NOME_DA_SUA_REDE_WIFI";
const char* password = "SENHA_DO_WIFI";


const char* serverName = "http://111.111.1"; 

void setup() {
  Serial.begin(1115200);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nConectado ao WiFi!");
}

void loop() {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    http.begin(serverName);
    http.addHeader("Content-Type", "application/json");

    int tremId = 1; 
    int velocidadeAtual = random(20, 80); 
    String statusSensor = "Ativo";

    String httpRequestData = "{\"trem_id\":" + String(tremId) + 
                             ",\"velocidade\":" + String(velocidadeAtual) + 
                             ",\"status_sensor\":\"" + statusSensor + "\"}";

    int httpResponseCode = http.POST(httpRequestData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println(httpResponseCode);
      Serial.println(response);
    } else {
      Serial.print("Erro no envio do POST: ");
      Serial.println(httpResponseCode);
    }
    http.end();
  }
  delay(3000); 
}
