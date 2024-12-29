# myapp/models.py
from django.db import models
from django.contrib.auth.models import User

class UserProfile(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    name = models.CharField(max_length=100)
    dob = models.DateField()
    bio = models.TextField()
    profile_pic = models.ImageField(upload_to='profile_pics/', null=True, blank=True)

class Goal(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    title = models.CharField(max_length=255)
    description = models.TextField()
    target_date = models.DateField()

class CheckIn(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    date = models.DateField()
    progress = models.TextField()

class Reminder(models.Model):
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    message = models.TextField()
    reminder_time = models.DateTimeField()
