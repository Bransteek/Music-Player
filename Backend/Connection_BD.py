import psycopg2

# Datos de conexión
host = "localhost"  # Dirección del servidor de la base de datos
dbname = "50_de_cilantro"  # Nombre de la base de datos
user = "postgres"  # Usuario de la base de datos
password = "1040871723"  # Contraseña del usuario
port = "5432"  # Puerto de la base de datos, el valor por defecto es 5432

# Conectarse a la base de datos
try:
    conn = psycopg2.connect(
        host=host,
        dbname=dbname,
        user=user,
        password=password,
        port=port
    )
    print("Conexión exitosa a la base de datos")

    # Crear un cursor para realizar operaciones en la base de datos
    cursor = conn.cursor()

    # Ejecutar una consulta SQL
    cursor.execute("SELECT version();")

    # Obtener el resultado de la consulta
    record = cursor.fetchone()
    print("Versión de PostgreSQL:", record)

    # Cerrar el cursor y la conexión
    cursor.close()
    conn.close()
    print("Conexión cerrada")

except Exception as error:
    print(f"Error al conectar a la base de datos: {error}")
