#include <SPI.h>
#include <Wire.h>

#define BLYNK_PRINT Serial
#include <WiFi.h>
#include <WiFiClient.h>
#include <BlynkSimpleEsp32.h>

#include "EmonLib.h"
EnergyMonitor emon1;

char auth[] = "l4Cm9MpjaRN5D1kPjAuXHT1nELkMuD_T";//Enter your Auth token
char ssid[] = "";//Enter your WIFI name
char pass[] = "";//Enter your WIFI password

BlynkTimer timer;

int adcPin = 34;

void setup() {

  Serial.begin(9600);

  emon1.current(35, 56.1); // input pin, calibration sensor.

  Blynk.begin(auth, ssid, pass, "blynk.cloud", 80);

    delay(500);

}

void loop() {

  Blynk.run();//Run the Blynk library
  timer.run();//Run the Blynk timer

}

void getcurrent()
  
{
  double voltage = adcPin*5/1023.0;
  double current = (voltage-2.5)/0.185;
  Serial.print("Current : ");
  Serial.println(current);
  Blynk.virtualWrite(V0,current);
  delay(300);
}

void getAcCurent ()

{
  double Irms = emon1.calcIrms(1480); 

  Serial.print(Irms);
  Blynk.virtualWrite(V1,Irms);
  delay(300);
}


