import base64
from cryptography.fernet import Fernet

def validate_token(token):
    try:
        f = Fernet(config.SECRET_KEY)
        decoded_data = f.decrypt(base64.urlsafe_b64decode(token.encode()))
        return int(decoded_data.decode())
    except Exception:
        return None  # Handle invalid token gracefully