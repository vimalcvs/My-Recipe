package com.gdevs.myrecipe.Models;

public class Category {

    private final String category_id;
    private final String category_name;
    private final String category_image;

    public Category(String category_id, String category_name, String category_image) {
        this.category_id = category_id;
        this.category_name = category_name;
        this.category_image = category_image;
    }

    public String getCategory_id() {
        return category_id;
    }

    public String getCategory_name() {
        return category_name;
    }

    public String getCategory_image() {
        return category_image;
    }
}
