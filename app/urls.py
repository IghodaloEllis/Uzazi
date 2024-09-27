"""
URL configuration for uzazilearning project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/5.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))

    TEST AS  http://127.0.0.1:8000/dashboard etc
"""
from django.contrib import admin
from django.urls import path, include
from . import views


urlpatterns = [
    path('admin/', admin.site.urls),

    path('dashboard/', views.dashboard, name='dashboard'),  # Dashboard page
    path('courses/', views.courses, name='courses'),  # Courses overview page
    path('lessons/<int:lesson_id>/', views.lessons, name='lessons'),  # Lesson detail page (with ID)
    path('modules/<int:module_id>/', views.modules, name='modules'),  # Module detail page (with ID)
 

    # We'll add more urls as we create them
]

