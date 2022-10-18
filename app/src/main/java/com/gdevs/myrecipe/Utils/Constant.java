package com.gdevs.myrecipe.Utils;


import com.gdevs.myrecipe.Config;

import java.io.Serializable;

public class Constant implements Serializable {


    public static final String URL_CATEGORY = Config.ADMIN_PANEL_URL +"/api/api.php?action=get_category";
    public static final String URL_CATEGORY_DETAIL = Config.ADMIN_PANEL_URL + "/api/api.php?action=get_category_detail";

    public static final String URL_RECENT_RECIPE = Config.ADMIN_PANEL_URL + "/api/api.php?action=get_recent&offset=0";

    public static final String URL_RECIPE_DETAILS = Config.ADMIN_PANEL_URL + "/api/api.php?action=get_recipe_details&id=";
    public static final String URL_SEARCH_WALLPAPER = Config.ADMIN_PANEL_URL + "/api/api.php?action=get_search";
    public static final String URL_PRIVACY_POLICY = Config.ADMIN_PANEL_URL + "/api/api.php?action=get_privacy_policy";
    public static final String URL_LOAD_DATA = Config.ADMIN_PANEL_URL + "/api/api.php?action=get_all_data";


    public static final String NO = "no";
    public static final String RecipeID = "RecipeId";
    public static final String RecipeName = "RecipeName";
    public static final String RecipeImage = "RecipeImage";
    public static final String RecipeVideo = "RecipeVideo";
    public static final String RecipeType = "RecipeType";
    public static final String RecipeDescription = "RecipeDescription";
    public static final String RecipeTime = "RecipeTime";
    public static final String RecipePerson = "RecipePerson";
    public static final String RecipeCategoryName = "category_name";


    public static final String CATEGORY_ID = "category_id";
    public static final String CATEGORY_NAME = "category_name";
    public static final String CATEGORY_IMAGE = "category_image";
    public static final String TOTAL_WALLPAPER = "total_wallpaper";

    public static final int DELAY_PROGRESS = 200;
    public static final int DELAY_REFRESH = 1000;
    public static final int DELAY_LOAD_MORE = 1500;
}
