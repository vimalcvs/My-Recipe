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
import com.gdevs.myrecipe.DetailsActivity;
import com.gdevs.myrecipe.Models.Recipe;
import com.gdevs.myrecipe.R;
import com.gdevs.myrecipe.Utils.PrefManager;

import java.util.ArrayList;


public class AdapterRecipe extends RecyclerView.Adapter<RecyclerView.ViewHolder>  {

    private final ArrayList<Recipe> wallpapers;
    private final Context context;
    private final int VIEW_HEAD = 1;
    private final int VIEW_ITEM = 2;
    PrefManager prf;

    public AdapterRecipe(Context context, ArrayList<Recipe> wallpapers) {
        this.context = context;
        this.wallpapers = wallpapers;
        this.prf = new PrefManager(context);
    }

    public static class HeadingViewHolder extends RecyclerView.ViewHolder {

        private final ImageView ivRecipeImage;
        private final ImageView ivRecipeVideo;
        TextView tvRecipeTime;
        TextView tvRecipeTitle;
        TextView tvRecipeCategory;
        LinearLayout llLayout;

        public HeadingViewHolder(View view) {
            super(view);
            ivRecipeImage = view.findViewById(R.id.ivRecipeImage);
            ivRecipeVideo = view.findViewById(R.id.ivRecipeVideo);
            tvRecipeTime = view.findViewById(R.id.tvRecipeTime);
            tvRecipeTitle = view.findViewById(R.id.tvRecipeTitle);
            tvRecipeCategory = view.findViewById(R.id.tvRecipeCategory);
            llLayout = view.findViewById(R.id.llMain);

        }
    }

    static class MyViewHolder extends RecyclerView.ViewHolder {

        private final ImageView ivRecipeImage;
        private final ImageView ivRecipeVideo;
        TextView tvRecipeTime;
        TextView tvRecipeTitle;
        TextView tvRecipeCategory;
        LinearLayout llLayout;


        MyViewHolder(View view) {
            super(view);

            ivRecipeImage = view.findViewById(R.id.ivRecipeImage);
            ivRecipeVideo = view.findViewById(R.id.ivRecipeVideo);
            tvRecipeTime = view.findViewById(R.id.tvRecipeTime);
            tvRecipeTitle = view.findViewById(R.id.tvRecipeTitle);
            tvRecipeCategory = view.findViewById(R.id.tvRecipeCategory);
            llLayout = view.findViewById(R.id.llMain);


        }
    }

    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

        switch (viewType) {
            case VIEW_HEAD:
                View headingItemView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_recipe_pager, parent, false);
                return new HeadingViewHolder(headingItemView);
            case VIEW_ITEM:

                if (prf.getString("grid").equals("true")){
                    View menuItemView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_recipe_pager, parent, false);
                    return new MyViewHolder(menuItemView);
                }else {
                    View menuItemView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_recipe, parent, false);
                    return new MyViewHolder(menuItemView);
                }


            default:
                View loadMoreView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_recipe, parent, false);
                return new MyViewHolder(loadMoreView);
        }

    }


    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, final int position) {

        int viewType = getItemViewType(position);
        switch (viewType) {
            case VIEW_HEAD:

                final HeadingViewHolder item_holder = (HeadingViewHolder) holder;
                Glide.with(context)
                        .load(Config.ADMIN_PANEL_URL+"/images/"+wallpapers.get(position).getRecipeImage())
                        .placeholder(R.drawable.placeholder)
                        .into(item_holder.ivRecipeImage);

                item_holder.tvRecipeTitle.setText(wallpapers.get(position).getRecipeName());
                item_holder.tvRecipeCategory.setText(wallpapers.get(position).getRecipeCategoryName());
                item_holder.tvRecipeTime.setText(wallpapers.get(position).getRecipeTime());

                if (wallpapers.get(position).getRecipeType().equals("video")) {
                    item_holder.ivRecipeVideo.setVisibility(View.VISIBLE);
                } else {
                    item_holder.ivRecipeVideo.setVisibility(View.INVISIBLE);
                }
                item_holder.llLayout.setOnClickListener(view -> {
                    Intent intent = new Intent(context, DetailsActivity.class);
                    intent.putExtra("recipeId", wallpapers.get(position).getId());
                    intent.putExtra("recipeCategoryName", wallpapers.get(position).getRecipeCategoryName());
                    context.startActivity(intent);
                });
                break;

            case VIEW_ITEM:

                final MyViewHolder myViewHolder = (MyViewHolder) holder;

                Glide.with(context)
                        .load(Config.ADMIN_PANEL_URL+"/images/"+wallpapers.get(position).getRecipeImage())
                        .placeholder(R.drawable.placeholder)
                        .into(myViewHolder.ivRecipeImage);

                myViewHolder.tvRecipeTitle.setText(wallpapers.get(position).getRecipeName());
                myViewHolder.tvRecipeCategory.setText(wallpapers.get(position).getRecipeCategoryName());
                myViewHolder.tvRecipeTime.setText(wallpapers.get(position).getRecipeTime());

                if (wallpapers.get(position).getRecipeType().equals("video")) {
                    myViewHolder.ivRecipeVideo.setVisibility(View.VISIBLE);
                } else {
                    myViewHolder.ivRecipeVideo.setVisibility(View.INVISIBLE);
                }

                myViewHolder.llLayout.setOnClickListener(view -> {
                    Intent intent = new Intent(context, DetailsActivity.class);
                    intent.putExtra("recipeId", wallpapers.get(position).getId());
                    intent.putExtra("recipeCategoryName", wallpapers.get(position).getRecipeCategoryName());
                    context.startActivity(intent);
                });

                break;
        }

    }

    @Override
    public int getItemCount() {
        return wallpapers.size();
    }

    @Override
    public int getItemViewType(int position) {

        if (wallpapers.get(position) != null) {
            if (position == 0) {
                return VIEW_HEAD;
            } else {
                return VIEW_ITEM;
            }
        } else {
            return VIEW_ITEM;
        }
    }

}