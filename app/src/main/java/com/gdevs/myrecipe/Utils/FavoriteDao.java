package com.gdevs.myrecipe.Utils;


import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;

import com.gdevs.myrecipe.Models.FavoriteRecipe;

import java.util.List;

@Dao
public interface FavoriteDao {
    @Insert
    public void addData(FavoriteRecipe favoriteList);

    @Query("select * from favoritelist")
    public List<FavoriteRecipe> getFavoriteData();

    @Query("SELECT EXISTS (SELECT 1 FROM favoritelist WHERE id=:id)")
    public int isFavorite(int id);

    @Delete
    public void delete(FavoriteRecipe favoriteList);


}
