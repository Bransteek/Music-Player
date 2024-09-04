from flask import Flask, request, render_template
import psycopg2

app = Flask(__name__)

# Datos de conexión
host = "localhost"
dbname = "50_de_cilantro"
user = "postgres"
password = "1040871723"
port = "5432"

# Conectar a la base de datos
def get_db_connection():
    conn = psycopg2.connect(
        host=host,
        dbname=dbname,
        user=user,
        password=password,
        port=port
    )
    return conn

@app.route('/')
def index():
    # Renderizar el archivo HTML desde la carpeta 'templates'
    return render_template('index.html')

@app.route('/submit', methods=['POST'])
def submit():
    username = request.form['username']
    password = request.form['password']

    conn = get_db_connection()
    cursor = conn.cursor()

    # Consultar la base de datos para verificar las credenciales
    cursor.execute('''
        SELECT * FROM "User"
        WHERE "User_name" = %s AND "Password" = %s
    ''', (username, password))

    user = cursor.fetchone()
    cursor.close()
    conn.close()

    if user:
        return 'Ingreso exitoso!'
    else:
        return 'Usuario o contraseña incorrectos.'

if __name__ == '__main__':
    app.run(debug=True)

