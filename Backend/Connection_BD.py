from flask import Flask, request, render_template_string
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
    # HTML del formulario
    html_form = '''
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" href="../Image/Logo.ico" type="image/x-icon" />
        <title>Aizi</title>
      </head>
      <body>
        <section class="form-login">
          <h5>Iniciar Sesion</h5>
          <form method="post" action="/submit">
            <input
              class="controls"
              type="text"
              name="username"
              placeholder="Usuario"
              required
            />
            <input
              class="controls"
              type="password"
              name="password"
              placeholder="Contraseña"
              required
            />
            <button class="buttons" type="submit">Submit</button>
          </form>
          <p><a href="#">¿Has olvidado tu contraseña?</a></p>
        </section>
      </body>
    </html>
    '''
    return render_template_string(html_form)

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
