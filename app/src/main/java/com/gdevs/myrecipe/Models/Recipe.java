package com.gdevs.myrecipe.Models;

import androidx.room.ColumnInfo;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

import java.io.Serializable;

@Entity(tableName="favoritelist")
public class Recipe implements Serializable {

    @PrimaryKey
    String id;
    @ColumnInfo(name = "recipe_name")
    String recipeName;
    @ColumnInfo(name = "recipe_image")
    String recipeImage;
    @ColumnInfo(name = "recipe_video")
    String recipeVideo;
    @ColumnInfo(name = "recipe_type")
    String recipeType;
    @ColumnInfo(name = "recipe_description")
    String recipeDescription;
    @ColumnInfo(name = "recipe_time")
    String recipeTime;
    @ColumnInfo(name = "recipe_person")
    String recipePerson;
    @ColumnInfo(name = "recipe_category")
    String recipeCategoryName;

    public Recipe() {
    }

    public Recipe(String id, String recipeName, String recipeImage, String recipeVideo, String recipeType, String recipeDescription, String recipeTime, String recipePerson, String recipeCategoryName) {
        this.id = id;
        this.recipeName = recipeName;
        this.recipeImage = recipeImage;
        this.recipeVideo = recipeVideo;
        this.recipeType = recipeType;
        this.recipeDescription = recipeDescription;
        this.recipeTime = recipeTime;
        this.recipePerson = recipePerson;
        this.recipeCategoryName = recipeCategoryName;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getRecipeName() {
        return recipeName;
    }

    public void setRecipeName(String recipeName) {
        this.recipeName = recipeName;
    }

    public String getRecipeImage() {
        return recipeImage;
    }

    public void setRecipeImage(String recipeImage) {
        this.recipeImage = recipeImage;
    }

    public String getRecipeVideo() {
        return recipeVideo;
    }

    public void setRecipeVideo(String recipeVideo) {
        this.recipeVideo = recipeVideo;
    }

    public String getRecipeType() {
        return recipeType;
    }

    public void setRecipeType(String recipeType) {
        this.recipeType = recipeType;
    }

    public String getRecipeDescription() {
        return recipeDescription;
    }

    public void setRecipeDescription(String recipeDescription) {
        this.recipeDescription = recipeDescription;
    }

    public String getRecipeTime() {
        return recipeTime;
    }

    public void setRecipeTime(String recipeTime) {
        this.recipeTime = recipeTime;
    }

    public String getRecipePerson() {
        return recipePerson;
    }

    public void setRecipePerson(String recipePerson) {
        this.recipePerson = recipePerson;
    }

    public String getRecipeCategoryName() {
        return recipeCategoryName;
    }

    public void setRecipeCategoryName(String recipeCategoryName) {
        this.recipeCategoryName = recipeCategoryName;
    }
}
