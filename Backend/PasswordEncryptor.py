import hashlib
import os

def enctryp(password):
    salt = os.urandom(16)
    hashed = hashlib.pbkdf2_hmac('sha256', password.encode('utf-8'), salt, 100000)

    return hashed




print(enctryp("hola"))