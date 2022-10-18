package com.gdevs.myrecipe;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.FragmentManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.Request;
import com.android.volley.toolbox.JsonObjectRequest;
import com.bumptech.glide.Glide;
import com.facebook.ads.Ad;
import com.facebook.ads.AdError;
import com.facebook.ads.AdSettings;
import com.facebook.ads.InterstitialAdListener;
import com.gdevs.myrecipe.Models.FavoriteRecipe;
import com.gdevs.myrecipe.Utils.Constant;
import com.gdevs.myrecipe.Utils.PrefManager;
import com.google.android.gms.ads.AdListener;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdSize;
import com.google.android.gms.ads.AdView;
import com.google.android.gms.ads.InterstitialAd;
import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import org.json.JSONException;

import java.util.ArrayList;

public class DetailsActivity extends AppCompatActivity {

    TextView tvRecipeName;
    TextView tvRecipeTime;
    TextView tvRecipeCategory;
    TextView tvViews;
    WebView wvDesc;
    ImageView ivRecipeImage;
    ImageView ivRecipeVideo;
    RelativeLayout rlMain;
    LinearLayout llParent;

    String recipeName;
    String recipeTime;
    String recipePerson;
    String recipeCategory;
    String recipeDesc;
    String recipeImage;
    String recipeType;
    String recipeVideo;
    String recipeId;
    String recipeCategoryName;
    String text;
    private Menu menu;
    int recipeIdInt;
    ArrayList<String> mIngredient;
    FragmentManager fragmentManager;
    PrefManager prf;
    SwipeRefreshLayout swipeRefreshLayout;
    FloatingActionButton fab;
    InterstitialAd interstitialAd;
    com.facebook.ads.InterstitialAd fbInterstitialAd;
    private final String TAG = DetailsActivity.class.getSimpleName();

    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        prf = new PrefManager(this);

        Intent intent = getIntent();
        recipeCategoryName = intent.getStringExtra("recipeCategoryName");
        recipeId = intent.getStringExtra("recipeId");


        if (prf.getString(Config.ADS).equals("true")){
            loadBannerAds();
            showFullScreenAds();
        }else{
            Log .d("OFF","ADS");
        }

        mIngredient = new ArrayList<>();
        tvRecipeName = findViewById(R.id.tvRecipeName);
        ivRecipeImage = findViewById(R.id.ivRecipeImage);
        ivRecipeVideo = findViewById(R.id.ivRecipeVideo);
        tvRecipeTime = findViewById(R.id.tvRecipeTime);
        tvViews = findViewById(R.id.tvViews);
        tvRecipeCategory = findViewById(R.id.tvRecipeCategory);
        fab = findViewById(R.id.fab);
        wvDesc = findViewById(R.id.wvDesc);
        rlMain = findViewById(R.id.rlMain);
        llParent = findViewById(R.id.llParent);
        fragmentManager = getSupportFragmentManager();

        swipeRefreshLayout = findViewById(R.id.swipeRefreshLayout);
        swipeRefreshLayout.setColorSchemeResources(R.color.black);
        showRefresh(true);

        getRecipeDetails();

        swipeRefreshLayout.setOnRefreshListener(this::refreshData);

    }

    private void getRecipeDetails() {
        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET, Constant.URL_RECIPE_DETAILS+recipeId, null, response -> {
            showRefresh(false);
            rlMain.setVisibility(View.VISIBLE);
            try {

                recipeIdInt = response.getInt("id");
                recipeName = response.getString("recipe_name");
                recipeTime = response.getString("recipe_time");
                recipePerson = response.getString("recipe_person");
                recipeCategory = response.getString("recipe_person");
                recipeType = response.getString("recipe_type");
                recipeVideo = response.getString("recipe_video");
                recipeDesc = response.getString("recipe_description");
                recipeImage = response.getString("recipe_image");

                //set data to views
                tvRecipeName.setText(recipeName);
                tvRecipeTime.setText(recipeTime);
                tvRecipeCategory.setText(recipeCategoryName);
                tvViews.setText(recipePerson+" Person");

                WebSettings webSettings = wvDesc.getSettings();
                webSettings.setJavaScriptEnabled(true);
                if (prf.loadNightModeState()){
                    text = "<html><head><style type=\"text/css\">@font-face {font-family: bold;src: url(\"file:///android_asset/myfonts/normal.ttf\")}body,* {font-family: bold; background: #19202A; color:#ffffff; font-size: 16px;line-height:1.2}img{max-width:100%;height:auto; border-radius: 3px;}</style>";

                }else {
                    text = "<html><head><style type=\"text/css\">@font-face {font-family: bold;src: url(\"file:///android_asset/myfonts/normal.ttf\")}body,* {font-family: bold; color:#3A3D4E; font-size: 16px;line-height:1.2}img{max-width:100%;height:auto; border-radius: 3px;}</style>";

                }
                wvDesc.loadDataWithBaseURL("", text + "<div>" + recipeDesc + "</div>", "text/html", "utf-8", null);

                Glide.with(DetailsActivity.this)
                        .load(Config.ADMIN_PANEL_URL + "/images/" + recipeImage)
                        .placeholder(R.drawable.placeholder)
                        .centerCrop()
                        .into(ivRecipeImage);


                if (recipeType.equals("video")){
                    ivRecipeVideo.setVisibility(View.VISIBLE);
                    ivRecipeImage.setOnClickListener(v -> {
                        Intent intent = new Intent(getApplicationContext(), ActivityYoutubePlayer.class);
                        intent.putExtra("video_id", recipeVideo);
                        startActivity(intent);
                    });
                }else {
                    ivRecipeVideo.setVisibility(View.INVISIBLE);
                    ivRecipeImage.setOnClickListener(v -> {
                        Intent intent = new Intent(getApplicationContext(), ActivityFullSizeImage.class);
                        intent.putExtra("image_id", recipeImage);
                        startActivity(intent);
                    });
                }



            } catch (JSONException e) {
                e.printStackTrace();
            }
        }, error -> {

        });

        MyApplication.getInstance().addToRequestQueue(jsonObjReq);
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

    private void showFullScreenAds () {
        if (prf.getString(Config.ADS_NETWORK).equals("admob")) {
            interstitialAd = new InterstitialAd(this);
            interstitialAd.setAdUnitId(prf.getString(Config.ADMOB_INTER_ID));
            AdRequest request = new AdRequest.Builder().build();
            interstitialAd.loadAd(request);
            interstitialAd.setAdListener(new AdListener() {
                public void onAdLoaded () {
                    if (interstitialAd.isLoaded()) {
                        interstitialAd.show();
                    }
                }
            });
        }else {
            fbInterstitialAd = new com.facebook.ads.InterstitialAd(this, prf.getString(Config.FACEBOOK_INTER_ID));
            InterstitialAdListener interstitialAdListener = new InterstitialAdListener() {
                @Override
                public void onInterstitialDisplayed(Ad ad) {
                    Log.e(TAG, "Interstitial ad displayed.");
                }

                @Override
                public void onInterstitialDismissed(Ad ad) {
                    Log.e(TAG, "Interstitial ad dismissed.");
                }

                @Override
                public void onError(Ad ad, AdError adError) {
                    Log.e(TAG, "Interstitial ad failed to load: " + adError.getErrorMessage());
                }

                @Override
                public void onAdLoaded(Ad ad) {
                    Log.d(TAG, "Interstitial ad is loaded and ready to be displayed!");
                    fbInterstitialAd.show();
                }

                @Override
                public void onAdClicked(Ad ad) {
                    Log.d(TAG, "Interstitial ad clicked!");
                }

                @Override
                public void onLoggingImpression(Ad ad) {
                    Log.d(TAG, "Interstitial ad impression logged!");
                }
            };
            fbInterstitialAd.loadAd(
                    fbInterstitialAd.buildLoadAdConfig()
                            .withAdListener(interstitialAdListener)
                            .build());
        }
    }

    private void refreshData() {

        rlMain.setVisibility(View.GONE);
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {
                getRecipeDetails();
            }
        }, Constant.DELAY_REFRESH);

    }

    private void showRefresh(boolean show) {
        if (show) {
            swipeRefreshLayout.setRefreshing(true);
        } else {
            new Handler().postDelayed(() -> swipeRefreshLayout.setRefreshing(false), Constant.DELAY_PROGRESS);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(final Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        this.menu = menu;
        checkfavorite();
        return true;
    }

    private void checkfavorite() {
        if (MainActivity.favoriteDatabase.favoriteDao().isFavorite(recipeIdInt) == 1){
            menu.getItem(1).setIcon(ContextCompat.getDrawable(getApplicationContext(), R.drawable.ic_baseline_favorite));
        } else {
            menu.getItem(1).setIcon(ContextCompat.getDrawable(getApplicationContext(), R.drawable.ic_baseline_favorite_border));
        }
        if (Config.DEVELOPERS_NAME.equals("G-Developers")){
            Log.d("TAG","OK");
        }else {
            finish();
        }
    }

    @SuppressLint({"NonConstantResourceId", "UseCompatLoadingForDrawables"})
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {

            case R.id.action_favorite:

                FavoriteRecipe favoriteList = new FavoriteRecipe();
                 int id = recipeIdInt;
                 String name = recipeName;
                 String image = recipeImage;
                 String video = recipeVideo;
                 String type = recipeType;
                 String person = recipePerson;
                 String time = recipeTime;
                 String desc = recipeDesc;
                 String category = recipeCategoryName;

                 favoriteList.setId(id);
                 favoriteList.setRecipeName(name);
                 favoriteList.setRecipeImage(image);
                 favoriteList.setRecipeVideo(video);
                 favoriteList.setRecipeType(type);
                 favoriteList.setRecipePerson(person);
                 favoriteList.setRecipeTime(time);
                 favoriteList.setRecipeDescription(desc);
                 favoriteList.setRecipeCategoryName(category);

                  if (MainActivity.favoriteDatabase.favoriteDao().isFavorite(id) != 1) {
                      //fab.setImageResource(R.drawable.ic_baseline_favorite);
                      menu.getItem(1).setIcon(ContextCompat.getDrawable(getApplicationContext(), R.drawable.ic_baseline_favorite));
                      MainActivity.favoriteDatabase.favoriteDao().addData(favoriteList);
                      Toast.makeText(DetailsActivity.this, "Added to Favorite", Toast.LENGTH_SHORT).show();

                  } else {
                      menu.getItem(1).setIcon(ContextCompat.getDrawable(getApplicationContext(), R.drawable.ic_baseline_favorite_border));
                      MainActivity.favoriteDatabase.favoriteDao().delete(favoriteList);
                      Toast.makeText(DetailsActivity.this, "Remove From Favorite", Toast.LENGTH_SHORT).show();
                            }

                return true;

            case R.id.action_share:

                Intent shareIntent = new Intent(Intent.ACTION_SEND);
                shareIntent.setType("text/plain");
                shareIntent.putExtra(Intent.EXTRA_TEXT,  recipeName + "Check it out : - \n https://play.google.com/store/apps/details?id=" + getPackageName());
                shareIntent.putExtra(Intent.EXTRA_SUBJECT, "My Recipe");
                startActivity(Intent.createChooser(shareIntent, "Share"));

                return true;

            case android.R.id.home:
                finish();
            default:
                return super.onOptionsItemSelected(item);
        }
    }
}