import hashlib

# Cadena de texto que deseas encriptar
texto = "HolaMundo123"

# Crear un objeto de hash sha256
hash_obj = hashlib.sha256()

# Actualizar el objeto con la cadena de texto
hash_obj.update(texto.encode('utf-8'))

# Obtener el valor hash en hexadecimal
hash_hex = hash_obj.hexdigest()

print(f"Texto original: {texto}")
print(f"Hash SHA-256: {hash_hex}")
