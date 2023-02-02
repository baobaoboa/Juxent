package com.taltos.juxent.models;

public class Template_Notification {
    //    Setting up variables
    String notification;
    String date;

    //    Setting up a constructor
    //    Constructor is almost the same as method but this instead uses
    //    the class name itself and doesn't have return value
    public Template_Notification(String notification, String date) {
        this.notification = notification;
        this.date         = date;
    }

    //    Getter methods
    public String getNotification() {
        return notification;
    }

    public String getDate() {
        return date;
    }
}
