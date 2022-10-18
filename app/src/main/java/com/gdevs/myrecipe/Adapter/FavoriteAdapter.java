package com.gdevs.myrecipe.Adapter;

import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.gdevs.myrecipe.Config;
import com.gdevs.myrecipe.DetailsOfflineActivity;
import com.gdevs.myrecipe.Models.FavoriteRecipe;
import com.gdevs.myrecipe.R;
import com.gdevs.myrecipe.Utils.PrefManager;

import java.util.List;

public class FavoriteAdapter extends RecyclerView.Adapter<FavoriteAdapter.ViewHolder>{
    private final List<FavoriteRecipe> favoriteLists;
    Context mCtx;
    PrefManager prf;

    public FavoriteAdapter(List<FavoriteRecipe> favoriteLists, Context mCtx) {
        this.favoriteLists = favoriteLists;
        this.mCtx = mCtx;
        prf = new PrefManager(mCtx);

    }

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup viewGroup, int i) {

            View view = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.item_recipe, viewGroup, false);
            return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull final ViewHolder holder, final int i) {
        final FavoriteRecipe fl = favoriteLists.get(i);

        Glide.with(mCtx)
                .load(Config.ADMIN_PANEL_URL + "/images/" + fl.getRecipeImage())
                .placeholder(R.drawable.placeholder)
                .centerCrop()
                .into(holder.ivRecipeImage);

        holder.tvRecipeName.setText(fl.getRecipeName());
        holder.tvRecipeTime.setText(fl.getRecipeTime());
        holder.tvRecipeCategory.setText(fl.getRecipeCategoryName());

        if (fl.getRecipeType().equals("video")){
            holder.ivRecipeVideo.setVisibility(View.VISIBLE);
        }else {
            holder.ivRecipeVideo.setVisibility(View.GONE);
        }

        holder.llMain.setOnClickListener(v -> {

            Intent intent = new Intent(mCtx, DetailsOfflineActivity.class);
            intent.putExtra("recipeName", fl.getRecipeName());
            intent.putExtra("recipeTime", fl.getRecipeTime());
            intent.putExtra("recipePerson", fl.getRecipePerson());
            intent.putExtra("recipeCategory", fl.getRecipeCategoryName());
            intent.putExtra("recipeDesc", fl.getRecipeDescription());
            intent.putExtra("recipeImage", fl.getRecipeImage());
            intent.putExtra("recipeType", fl.getRecipeType());
            intent.putExtra("recipeVideo", fl.getRecipeVideo());
            intent.putExtra("recipeId", fl.getId());
            intent.putExtra("recipeCategoryName", fl.getRecipeCategoryName());
            intent.putExtra("recipe_id", fl.getId());
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            mCtx.startActivity(intent);
        });

    }

    @Override
    public int getItemCount() {
        return favoriteLists.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder{

        TextView tvRecipeName;
        ImageView ivRecipeImage;
        ImageView ivRecipeVideo;
        TextView tvRecipeTime;
        TextView tvRecipeCategory;
        LinearLayout llMain;

        public ViewHolder(@NonNull View view) {
            super(view);

            tvRecipeName = view.findViewById(R.id.tvRecipeTitle);
            ivRecipeImage = view.findViewById(R.id.ivRecipeImage);
            tvRecipeTime = view.findViewById(R.id.tvRecipeTime);
            tvRecipeCategory = view.findViewById(R.id.tvRecipeCategory);
            ivRecipeVideo = view.findViewById(R.id.ivRecipeVideo);
            llMain = view.findViewById(R.id.llMain);


        }
    }
}
