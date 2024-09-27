from django.shortcuts import render

    # Your logic to prepare data for the dashboard we will use a redirection since
    # user sessions are carried bewteen bth applications. We might find another alternative in the future.

def dashboard(request):
    context = {'data': 'Dashboard content'}
    return render(request, 'templates/dashboard.html', context)

#def dashboard(request):
#    user = request.user  # Assuming we have user authentication
#    courses = Course.objects.filter(student=user)  # Assuming we have a Course model
#    context = {'user': user, 'courses': courses}
#    return render(request, 'templates/dashboard.html', context)

def courses(request):
    # Your logic to retrieve and display courses information
    context = {'courses': 'List of courses'}  # Example data
    return render(request, 'templates/courses.html', context)

def lessons(request, lesson_id):
    # Your logic to retrieve and display lesson details based on the ID
    context = {'lesson': 'Detailed lesson information'}  # Example data
    return render(request, 'templates/lessons.html', context)

def modules(request, module_id):
    # Your logic to retrieve and display module details based on the ID
    context = {'module': 'Detailed module information'}  # Example data
    return render(request, 'templates/modules.html', context)


