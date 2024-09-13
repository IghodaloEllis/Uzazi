

from flask import Blueprint, jsonify, request
from app import db, models
from flask_login import login_required, current_user

courses_bp = Blueprint('courses', __name__)

@courses_bp.route('/courses', methods=['GET'])
@login_required
def get_courses():
    user_id = current_user.id  # Retrieve user ID from Flask-Login
    courses = models.Course.query.filter_by(user_id=user_id).all()
    return jsonify([course.serialize() for course in courses])

# ... (other course-related functions)