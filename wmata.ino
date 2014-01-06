// wmata.ino
const int redLed = 11;
const int greenLed = 10;
const int blueLed = 9;

int incomingByte = 0;

void setup() {
  Serial.begin(9600);

  pinMode(redLed, OUTPUT);
  pinMode(greenLed, OUTPUT);
  pinMode(blueLed, OUTPUT);
}

void loop() {
  if (Serial.available() > 0) {
    incomingByte = Serial.read();
    switch (incomingByte) {
    case 48:
      //nothing
      analogWrite(redLed, 0);
      analogWrite(greenLed, 0);
      analogWrite(blueLed, 0);
      break;
    case 49:
      //red
      analogWrite(redLed, 255);
      analogWrite(greenLed, 0);
      analogWrite(blueLed, 0);
      break;
    case 50:
      //blue
      analogWrite(redLed, 0);
      analogWrite(greenLed, 0);
      analogWrite(blueLed, 255);
      break;
    case 51:
      //green
      analogWrite(redLed, 0);
      analogWrite(greenLed, 255);
      analogWrite(blueLed, 0);
      break;
    case 52:
      //orange
      analogWrite(redLed, 255);
      analogWrite(greenLed, 128);
      analogWrite(blueLed, 0);
      break;
    case 53:
      //yellow
      analogWrite(redLed, 128);
      analogWrite(greenLed, 255);
      analogWrite(blueLed, 0);
    default:
      //nothing
      break;
    }
  }
  incomingByte = 0;
}
