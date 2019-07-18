import serial
import json
import requests


arduino = serial.Serial(
    port='/dev/tty.usbmodem14101',
    baudrate=9600,
    parity=serial.PARITY_NONE,
    stopbits=serial.STOPBITS_ONE,
    bytesize=serial.EIGHTBITS,
    timeout=1
)
print("connected to: " + arduino.portstr)

while True:
    dataline = arduino.readline().decode().rstrip();
    if (dataline):
        print("json:", dataline);
        try:
            j = json.loads(dataline);
            print(j);

            url = 'http://localhost/drone-data/frontend/web/api/push';
            data = {'data': dataline};
            response = requests.post(url, data=data)
            print(response.text);
        except Exception as e:
            print('Decoding JSON has failed')
