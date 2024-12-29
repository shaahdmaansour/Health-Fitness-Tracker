# myapp/views.py
from django.shortcuts import render, redirect
from django.contrib.auth import login, authenticate, logout
from django.contrib.auth.forms import AuthenticationForm
from .forms import SignupForm, UserProfileForm
from .models import UserProfile

# Login View
def login_view(request):
    if request.method == "POST":
        form = AuthenticationForm(request, data=request.POST)
        if form.is_valid():
            user = form.get_user()
            login(request, user)
            return redirect('home')
    else:
        form = AuthenticationForm()
    return render(request, 'login.html', {'form': form})

# Signup View
def signup_view(request):
    if request.method == 'POST':
        form = SignupForm(request.POST)
        if form.is_valid():
            user = form.save(commit=False)
            user.set_password(form.cleaned_data['password'])
            user.save()
            # Create a user profile
            UserProfile.objects.create(user=user)
            return redirect('login')
    else:
        form = SignupForm()
    return render(request, 'signup.html', {'form': form})

# User Profile View
def user_profile_view(request):
    user_profile = UserProfile.objects.get(user=request.user)
    return render(request, 'user_profile.html', {'user_profile': user_profile})

# Home View
def home_view(request):
    return render(request, 'home.html')

# Logout View
def logout_user(request):
    logout(request)
    return redirect('login')

# Goals View
def goals_view(request):
    goals = Goal.objects.filter(user=request.user)
    return render(request, 'goals.html', {'goals': goals})

# Check-In View
def check_in_view(request):
    checkins = CheckIn.objects.filter(user=request.user)
    return render(request, 'checkin.html', {'checkins': checkins})

# Reminders View
def reminders_view(request):
    reminders = Reminder.objects.filter(user=request.user)
    return render(request, 'reminders.html', {'reminders': reminders})

# Settings View
def settings_view(request):
    if request.method == "POST":
        form = UserProfileForm(request.POST, instance=request.user.userprofile)
        if form.is_valid():
            form.save()
            return redirect('user_profile')
    else:
        form = UserProfileForm(instance=request.user.userprofile)
    return render(request, 'settings.html', {'form': form})
