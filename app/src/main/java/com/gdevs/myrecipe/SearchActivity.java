package com.gdevs.myrecipe;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.facebook.ads.AdSettings;
import com.gdevs.myrecipe.Adapter.AdapterRecipe;
import com.gdevs.myrecipe.Models.Recipe;
import com.gdevs.myrecipe.Utils.Constant;
import com.gdevs.myrecipe.Utils.Methods;
import com.gdevs.myrecipe.Utils.PrefManager;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdSize;
import com.google.android.gms.ads.AdView;
import com.google.android.material.snackbar.Snackbar;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class SearchActivity extends AppCompatActivity {

    SwipeRefreshLayout swipeRefreshLayout = null;
    RecyclerView recyclerView;
    RelativeLayout lytParent;
    private boolean itShouldLoadMore = true;
    private AdapterRecipe mAdapter;
    private ArrayList<Recipe> arrayList;
    ProgressBar progressBar;
    View lytNoItem;
    Methods methods;
    PrefManager prf;
    String recipeSearch;

    @Override
    protected void onCreate (Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_recipes);
        prf = new PrefManager(this);

        Intent intent = getIntent();
        recipeSearch = intent.getStringExtra("recipeSearch");

        
        setTitle(recipeSearch);
       



        if (prf.getString(Config.ADS).equals("true")){
            loadBannerAds();
        }else {
            Log.d("OFF","ADS");
        }

        lytParent = findViewById(R.id.lyt_parent);
        lytNoItem = findViewById(R.id.lyt_no_item);

        methods = new Methods(this);


        swipeRefreshLayout = findViewById(R.id.swipeRefreshLayout);
        swipeRefreshLayout.setColorSchemeResources(R.color.black);
        showRefresh(true);

        progressBar = findViewById(R.id.relativeLayoutLoadMore);

        arrayList = new ArrayList<>();
        mAdapter = new AdapterRecipe(this, arrayList);

        recyclerView = findViewById(R.id.recyclerView);

        recyclerView.setLayoutManager(new LinearLayoutManager(this));

        recyclerView.setHasFixedSize(true);

        recyclerView.setAdapter(mAdapter);

        firstLoadData();

        recyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {

            @Override
            public void onScrolled(@NonNull RecyclerView recyclerView, int dx, int dy) {
                super.onScrolled(recyclerView, dx, dy);
                if (dy > 0) {
                    if (!recyclerView.canScrollVertically(RecyclerView.FOCUS_DOWN)) {
                        if (itShouldLoadMore) {
                            loadMore();
                        }
                    }
                }
            }
        });

        swipeRefreshLayout.setOnRefreshListener(this::refreshData);
    }

    private void loadBannerAds() {
        if (prf.getString(Config.ADS_NETWORK).equals("admob")){
            AdView adView = new AdView(this);
            adView.setAdUnitId(prf.getString(Config.ADMOB_BANNER_ID));
            adView.setAdSize(AdSize.BANNER);
            LinearLayout layout = (LinearLayout) findViewById(R.id.adView);
            layout.addView(adView);
            AdRequest adRequest = new AdRequest.Builder().build();
            adView.loadAd(adRequest);
        }else {
            com.facebook.ads.AdView adView = new com.facebook.ads.AdView(this, prf.getString(Config.FACEBOOK_BANNER_ID), com.facebook.ads.AdSize.BANNER_HEIGHT_50);
            LinearLayout adContainer = (LinearLayout) findViewById(R.id.adView);
            adContainer.addView(adView);
            AdSettings.addTestDevice(Config.DEVICE_ID);
            adView.loadAd();
        }
    }

    private void firstLoadData() {
        if (methods.isNetworkAvailable()) {
            itShouldLoadMore = false;

            JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, Constant.URL_SEARCH_WALLPAPER + "&search=" + recipeSearch + "&offset=0", null, response -> {

                showRefresh(false);
                itShouldLoadMore = true;

                if (response.length() <= 0) {
                    lytNoItem.setVisibility(View.VISIBLE);
                    return;
                }

                for (int i = 0; i < response.length(); i++) {
                    try {
                        JSONObject jsonObject = response.getJSONObject(i);

                        String recipeId = jsonObject.getString(Constant.RecipeID);
                        String recipeName = jsonObject.getString(Constant.RecipeName);
                        String recipeImage = jsonObject.getString(Constant.RecipeImage);
                        String recipeVideo = jsonObject.getString(Constant.RecipeVideo);
                        String recipeType = jsonObject.getString(Constant.RecipeType);
                        String recipeDescription = jsonObject.getString(Constant.RecipeDescription);
                        String recipeTime = jsonObject.getString(Constant.RecipeTime);
                        String recipePerson = jsonObject.getString(Constant.RecipePerson);
                        String recipeCategoryName = jsonObject.getString(Constant.RecipeCategoryName);

                        arrayList.add(new Recipe(recipeId, recipeName, recipeImage, recipeVideo, recipeType, recipeDescription, recipeTime, recipePerson, recipeCategoryName));
                        mAdapter.notifyDataSetChanged();


                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }

            }, error -> {
                itShouldLoadMore = true;
                showRefresh(false);
            });

            MyApplication.getInstance().addToRequestQueue(jsonArrayRequest);

        } else {
            showRefresh(false);
            mAdapter = new AdapterRecipe(this, arrayList);
            recyclerView.setAdapter(mAdapter);
        }

    }

    private void loadMore() {

        itShouldLoadMore = false;
        progressBar.setVisibility(View.VISIBLE);

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, Constant.URL_SEARCH_WALLPAPER + "&search=" + recipeSearch + "&offset=0", null, response -> new Handler().postDelayed(() -> {

            showRefresh(false);
            progressBar.setVisibility(View.GONE);
            itShouldLoadMore = true;

            if (response.length() <= 0) {
                return;
            }

            for (int i = 0; i < response.length(); i++) {
                try {
                    JSONObject jsonObject = response.getJSONObject(i);

                    String recipeId = jsonObject.getString(Constant.RecipeID);
                    String recipeName = jsonObject.getString(Constant.RecipeName);
                    String recipeImage = jsonObject.getString(Constant.RecipeImage);
                    String recipeVideo = jsonObject.getString(Constant.RecipeVideo);
                    String recipeType = jsonObject.getString(Constant.RecipeType);
                    String recipeDescription = jsonObject.getString(Constant.RecipeDescription);
                    String recipeTime = jsonObject.getString(Constant.RecipeTime);
                    String recipePerson = jsonObject.getString(Constant.RecipePerson);
                    String recipeCategoryName = jsonObject.getString(Constant.RecipeCategoryName);

                    arrayList.add(new Recipe(recipeId, recipeName, recipeImage, recipeVideo, recipeType, recipeDescription, recipeTime, recipePerson, recipeCategoryName));
                    mAdapter.notifyDataSetChanged();

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

        }, Constant.DELAY_LOAD_MORE), error -> {
            progressBar.setVisibility(View.GONE);
            showRefresh(false);
            itShouldLoadMore = true;
            isOffline();
        });

        MyApplication.getInstance().addToRequestQueue(jsonArrayRequest);

    }

    private void refreshData() {

        lytNoItem.setVisibility(View.GONE);
        arrayList.clear();
        mAdapter.notifyDataSetChanged();
        new Handler().postDelayed(this::firstLoadData, Constant.DELAY_REFRESH);

    }

    private void isOffline() {
        Snackbar snackBar = Snackbar.make(lytParent, "msg_offline", Snackbar.LENGTH_LONG);
        snackBar.setAction("option_retry", view -> {
            showRefresh(true);
            refreshData();
        });
        snackBar.show();
    }

    private void showRefresh(boolean show) {
        if (show) {
            swipeRefreshLayout.setRefreshing(true);
        } else {
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    swipeRefreshLayout.setRefreshing(false);
                }
            }, Constant.DELAY_PROGRESS);
        }
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        if (item.getItemId() == android.R.id.home) {
            finish();
        }
        return super.onOptionsItemSelected(item);
    }

    @Override
    public void onResume() {
        initCheck();
        super.onResume();
    }

    private void initCheck() {
        if (prf.loadNightModeState()){
            Log.d("Dark", "MODE");
        }else {
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR);   // set status text dark
            }
        }
    }

}