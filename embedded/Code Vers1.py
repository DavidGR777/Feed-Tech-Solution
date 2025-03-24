import RPi.GPIO as GPIO
from pirc522 import RFID
import sqlite3
import requests
from datetime import datetime

# Nombre de la base de datos SQLite
db_name = 'vacas.db'

# Inicialización del lector RFID
GPIO.setmode(GPIO.BOARD)
GPIO.setwarnings(False)
rc522 = RFID()

# Configuración de ThingSpeak
thingspeak_api_key = 'J9V3Q9CKR3FH5ZRP'
thingspeak_url = f'https://api.thingspeak.com/update?api_key={thingspeak_api_key}'

# Función para leer el UID de la tarjeta RFID
def leer_tag():
    try:
        print('Acercar una tarjeta RFID...')
        rc522.wait_for_tag()
        error, _ = rc522.request()
        if not error:
            error, uid = rc522.anticoll()
            if not error:
                uid_str = ''.join(map(str, uid))
                print(f'Tarjeta RFID detectada. UID: {uid_str}')
                return uid_str
        return None
    except KeyboardInterrupt:
        GPIO.cleanup()
        raise

# Función para crear la tabla de vacas si no existe
def crear_tabla_vacas():
    conn = sqlite3.connect(db_name)
    c = conn.cursor()
    c.execute('''CREATE TABLE IF NOT EXISTS vacas (
                    uid TEXT PRIMARY KEY,
                    nombre TEXT,
                    edad INTEGER,
                    peso REAL,
                    id_ternera INTEGER
                )''')
    conn.commit()
    conn.close()

# Función para guardar datos de una vaca en la base de datos
def guardar_datos(uid, nombre, edad, peso, id_ternera):
    conn = sqlite3.connect(db_name)
    c = conn.cursor()
    try:
        c.execute("INSERT INTO vacas (uid, nombre, edad, peso, id_ternera) VALUES (?, ?, ?, ?, ?)",
                  (uid, nombre, edad, peso, id_ternera))
        conn.commit()
        print(f"Datos para la vaca con UID {uid} guardados correctamente en la base de datos.")

        # Enviar datos actualizados a ThingSpeak
        enviar_a_thingspeak_nuevo(uid, nombre)  # Enviar el valor de 1 para contar una nueva vaca
        enviar_a_thingspeak_edad(uid, nombre, edad)  # Enviar la edad al campo field2 de ThingSpeak
        
    except sqlite3.Error as e:
        print("Error al guardar los datos:", e)
    finally:
        conn.close()

# Función para enviar datos actualizados a ThingSpeak
def enviar_a_thingspeak_nuevo(uid, nombre):
    try:
        payload = {'api_key': thingspeak_api_key, 'field1': 1}  # Enviar siempre 1 para contar una nueva vaca
        response = requests.post(thingspeak_url, params=payload)
        
        if response.status_code == 200:
            print(f'Conteo de vacas actualizado en ThingSpeak para la vaca {nombre}.')
        else:
            print(f'Error al actualizar el conteo de vacas en ThingSpeak. Código de estado: {response.status_code}')
    
    except Exception as e:
        print(f'Error en la solicitud HTTP: {e}')


def enviar_a_thingspeak_edad(uid, nombre, edad):
    try:
        print(f'Enviando edad ({edad}) de la vaca {nombre} ({uid}) a ThingSpeak...')
        payload = {'api_key': thingspeak_api_key, 'field2': edad}
        response = requests.post(thingspeak_url, params=payload)
        
        if response.status_code == 200:
            print(f'Edad de la vaca {nombre} ({uid}) enviada correctamente a ThingSpeak.')
        else:
            print(f'Error al enviar la edad de la vaca a ThingSpeak. Código de estado: {response.status_code}')
            print('Contenido de la respuesta:', response.content)
    
    except Exception as e:
        print(f'Error en la solicitud HTTP: {e}')

# Función para actualizar datos de una vaca en la base de datos
def cambiar_datos(uid):
    conn = sqlite3.connect(db_name)
    c = conn.cursor()
    try:
        c.execute("SELECT * FROM vacas WHERE uid = ?", (uid,))
        row = c.fetchone()
        if row:
            print(f"La vaca con UID {uid} ya ha sido registrada anteriormente.")
            respuesta = input('¿Desea actualizar los datos de esta vaca? (S/N): ').lower()
            if respuesta == 's':
                nombre = input(f'Introduce el nuevo nombre para la vaca con UID {uid}: ')
                edad = int(input(f'Introduce la nueva edad para la vaca con UID {uid}: '))
                peso = float(input(f'Introduce el nuevo peso para la vaca con UID {uid} (kg): '))
                id_ternera = int(input(f'Introduce el ID de ternera para la vaca con UID {uid}: '))
                c.execute("UPDATE vacas SET nombre = ?, edad = ?, peso = ? WHERE uid = ?",
                          (nombre, edad, peso, uid))
                conn.commit()
                print(f'Datos para la vaca con UID {uid} actualizados correctamente.')
            else:
                print(f'Datos de la vaca con UID {uid}:')
                print(f'Nombre: {row[1]}, Edad: {row[2]}, Peso: {row[3]}, ID Ternera: {row[4]}')
        else:
            print(f'Vaca detectada con UID: {uid} y datos no asociados')
            respuesta = input('¿Desea asignar datos a esta vaca? (S/N): ').lower()
            if respuesta == 's':
                nombre = input(f'Introduce el nombre para la vaca con UID {uid}: ')
                edad = int(input(f'Introduce la edad en dias para la vaca con UID {uid}: '))
                peso = float(input(f'Introduce el peso para la vaca con UID {uid} (kg): '))
                id_ternera = int(input(f'Introduce el ID de ternera para la vaca con UID {uid}: '))
                guardar_datos(uid, nombre, edad, peso, id_ternera)
            else:
                respuesta = input('¿Desea introducir un nuevo tag? (S/N): ').lower()
                if respuesta != 's':
                    exit()
    except sqlite3.Error as e:
        print("Error al cambiar los datos:", e)
    finally:
        conn.close()

# Código principal
if __name__ == '__main__':
    crear_tabla_vacas()  # Crear la tabla 'vacas' si no existe
    print('En espera de una tarjeta RFID...')
    
    try:
        while True:
            uid = leer_tag()  # Detectar una tarjeta RFID y obtener su UID
            if uid:
                cambiar_datos(uid)  # Gestionar los datos de la vaca según el UID
    except KeyboardInterrupt:
        print('Proceso interrumpido.')
        GPIO.cleanup()
import RPi.GPIO as GPIO
import sqlite3
import time
import requests

SENSOR_PIN = 26
GPIO.setmode(GPIO.BCM)
GPIO.setup(SENSOR_PIN, GPIO.IN)

conn = sqlite3.connect('mediciones.db')
c = conn.cursor()

c.execute('''CREATE TABLE IF NOT EXISTS mediciones
             (id INTEGER PRIMARY KEY, volumen REAL, tiempo TEXT)''')

FACTOR_CONVERSION = 0.00225
VOLUMEN_DESEADO = 0.5

# Configuración de ThingSpeak
thingspeak_api_key = 'TU_API_KEY'
thingspeak_url = f'https://api.thingspeak.com/update?api_key={thingspeak_api_key}'

def medir_volumen(pin, volumen_deseado):
    contador = 0
    volumen_acumulado = 0
    volumen_alcanzado = False

    def contar_pulsos(pin):
        nonlocal contador
        contador += 1

    GPIO.add_event_detect(pin, GPIO.FALLING, callback=contar_pulsos)

    try:
        while not volumen_alcanzado:
            volumen_acumulado = contador * FACTOR_CONVERSION 
            tiempo_actual = time.strftime('%Y-%m-%d %H:%M:%S')
            c.execute("INSERT INTO mediciones (volumen, tiempo) VALUES (?, ?)", (volumen_acumulado, tiempo_actual))
            conn.commit()
            print("Volumen acumulado:", volumen_acumulado, "litros")

            # Enviar datos a ThingSpeak
            payload = {'field1': volumen_acumulado}
            response = requests.post(thingspeak_url, params=payload)
            if response.status_code == 200:
                print("Datos enviados a ThingSpeak.")

            if volumen_acumulado >= volumen_deseado:
                volumen_alcanzado = True  # Marcar que se alcanzó el volumen deseado

            time.sleep(0.1)  # Pausa de 0.1 segundos entre cada medición

    except KeyboardInterrupt:
        GPIO.remove_event_detect(pin)
        GPIO.cleanup()

    return volumen_acumulado

if __name__ == "__main__":
    resultado = medir_volumen(SENSOR_PIN, VOLUMEN_DESEADO)
    print("Volumen deseado alcanzado. Resultado:", resultado)

    # Imprimir el mensaje cada 5 segundos después de alcanzar el volumen deseado
    while True:
        print("¡Volumen deseado alcanzado!")
        time.sleep(10)  # Esperar 10 segundos antes de volver a imprimir el mensaje
