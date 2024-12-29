# myapp/urls.py
from django.urls import path
from . import views

urlpatterns = [
    path('login/', views.login_view, name='login'),
    path('signup/', views.signup_view, name='signup'),
    path('logout/', views.logout_user, name='logout'),
    path('user-profile/', views.user_profile_view, name='user_profile'),
    path('home/', views.home_view, name='home'),
    path('goals/', views.goals_view, name='goals'),
    path('checkin/', views.check_in_view, name='checkin'),
    path('reminders/', views.reminders_view, name='reminders'),
    path('settings/', views.settings_view, name='settings'),
]
