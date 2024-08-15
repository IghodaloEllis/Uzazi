from flask import Flask, request, jsonify
from flask_sqlalchemy import SQLAlchemy
import bcrypt

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///users.db'
db = SQLAlchemy(app)

class User(db.Model):
  id = db.Column(db.Integer, primary_key=True)
  username = db.Column(db.String(80), unique=True, nullable=False)
  password_hash = db.Column(db.String(120))

  def set_password(self, password):
    self.password_hash = bcrypt.hashpw(password.encode('utf-8'), bcrypt.gensalt())

  def check_password(self, password):
    return bcrypt.checkpw(password.encode('utf-8'), self.password_hash.encode('utf-8'))

# ... rest of the code for user registration and authentication ...
