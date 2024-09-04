"""from flask import Flask, request, render_template
import psycopg2

app = Flask(__name__)

# Configuración de la base de datos
DB_HOST = "localhost"
DB_NAME = "50_de_cilantro"
DB_USER = "postgres"
DB_PASSWORD = "Brian_2005"

# Página de inicio (formulario)
@app.route('/')
def home():
    return render_template('Login.html')

# Ruta para manejar el formulario
@app.route('/submit', methods=['POST'])
def submit():
    username = request.form.get('username')
    password = request.form.get('password')

    # Conectar a la base de datos y verificar credenciales
    try:
        conn = psycopg2.connect(
            host=DB_HOST,
            dbname=DB_NAME,
            user=DB_USER,
            password=DB_PASSWORD
        )
        cursor = conn.cursor()

        # Consulta para verificar las credenciales
        query = 'SELECT COUNT(*) FROM "User" WHERE "User_Name" = %s AND "Password" = %s'
        cursor.execute(query, (username, password))
        count = cursor.fetchone()[0]

        cursor.close()
        conn.close()

        if count > 0:
            return render_template('result.html', message="Inicio de sesión exitoso")
        else:
            return render_template('result.html', message="Credenciales incorrectas")

    except Exception as e:
        return f"Error al conectar a la base de datos: {e}"

if __name__ == '__main__':
    app.run(debug=True)"""
