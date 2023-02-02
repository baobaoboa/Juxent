package com.taltos.juxent.models;

public class Template_Sale {
    //    Setting up variables
    String id;
    String productPurchased;
    String softwareType;
    String warrantyStatus;
    Long daysRemaining;
    String date;

    //    Setting up a constructor
    //    Constructor is almost the same as method but this instead uses
    //    the class name itself and doesn't have return value
    public Template_Sale(String id, String productPurchased, String softwareType, String warrantyStatus, Long daysRemaining, String date) {
        this.id               = id;
        this.productPurchased = productPurchased;
        this.softwareType     = softwareType;
        this.warrantyStatus   = warrantyStatus;
        this.daysRemaining    = daysRemaining;
        this.date             = date;
    }

    //    Getter methods
    public String getId() {
        return id;
    }

    public String getProductPurchased() {
        return productPurchased;
    }

    public String getSoftwareType() {
        return softwareType;
    }

    public String getWarrantyStatus() {
        return warrantyStatus;
    }

    public Long getDaysRemaining() {
        return daysRemaining;
    }

    public String getDate() {
        return date;
    }
}