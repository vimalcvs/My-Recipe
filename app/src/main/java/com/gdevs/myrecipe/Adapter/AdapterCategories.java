package com.gdevs.myrecipe.Adapter;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.gdevs.myrecipe.Config;
import com.gdevs.myrecipe.Models.Category;
import com.gdevs.myrecipe.R;
import com.gdevs.myrecipe.RecipesActivity;

import java.util.ArrayList;

public class AdapterCategories extends RecyclerView.Adapter<AdapterCategories.MyViewHolder> implements Filterable {

    private final ArrayList<Category> categories;
    private ArrayList<Category> categoriesFiltered;
    private final Context context;

    public AdapterCategories(Context context, ArrayList<Category> categories) {
        this.context = context;
        this.categories = categories;
        this.categoriesFiltered = categories;
    }

    static class MyViewHolder extends RecyclerView.ViewHolder {

        private final ImageView img_category;
        TextView txt_category_name;
        RelativeLayout llMain;

        MyViewHolder(View view) {
            super(view);
            img_category = view.findViewById(R.id.ivCategory);
            txt_category_name = view.findViewById(R.id.tvCategory);
            llMain = view.findViewById(R.id.llMain);

        }
    }

    @NonNull
    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        return new MyViewHolder(LayoutInflater.from(parent.getContext()).inflate(R.layout.item_category, parent, false));
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, final int position) {


        Glide.with(context)
                .load(Config.ADMIN_PANEL_URL + "/images/" + categoriesFiltered.get(position).getCategory_image())
                .placeholder(R.drawable.placeholder)
                .centerCrop()
                .into(holder.img_category);
        holder.txt_category_name.setText(categoriesFiltered.get(position).getCategory_name());

        holder.llMain.setOnClickListener(v -> {

            Intent intent = new Intent(context, RecipesActivity.class);
            intent.putExtra("categoryID", categoriesFiltered.get(position).getCategory_id());
            intent.putExtra("categoryName", categoriesFiltered.get(position).getCategory_name());
            context.startActivity(intent);
        });

    }

    @Override
    public int getItemCount() {
        return categoriesFiltered.size();
    }

    @SuppressWarnings("unchecked")
    @Override
    public Filter getFilter() {
        return new Filter() {
            @Override
            protected FilterResults performFiltering(CharSequence charSequence) {
                String charString = charSequence.toString();
                if (charString.isEmpty()) {
                    categoriesFiltered = categories;
                } else {
                    ArrayList<Category> filteredList = new ArrayList<>();
                    for (Category row : categories) {
                        if (row.getCategory_name().toLowerCase().contains(charString.toLowerCase())) {
                            filteredList.add(row);
                        }
                    }
                    categoriesFiltered = filteredList;
                }

                FilterResults filterResults = new FilterResults();
                filterResults.values = categoriesFiltered;
                return filterResults;
            }

            @SuppressLint("NotifyDataSetChanged")
            @Override
            protected void publishResults(CharSequence charSequence, FilterResults filterResults) {
                categoriesFiltered = (ArrayList<Category>) filterResults.values;
                notifyDataSetChanged();
            }
        };
    }

}