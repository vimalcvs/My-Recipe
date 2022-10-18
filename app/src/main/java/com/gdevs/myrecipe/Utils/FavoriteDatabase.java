package com.gdevs.myrecipe.Utils;


import androidx.room.Database;
import androidx.room.RoomDatabase;

import com.gdevs.myrecipe.Models.FavoriteRecipe;


@Database(entities={FavoriteRecipe.class},version = 1)
public abstract class FavoriteDatabase extends RoomDatabase {

    public abstract FavoriteDao favoriteDao();


}
