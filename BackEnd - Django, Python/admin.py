# myapp/admin.py
from django.contrib import admin
from .models import UserProfile, Goal, CheckIn, Reminder

admin.site.register(UserProfile)
admin.site.register(Goal)
admin.site.register(CheckIn)
admin.site.register(Reminder)
