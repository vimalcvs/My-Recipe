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
import androidx.appcompat.widget.Toolbar;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.FragmentManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;
import com.bumptech.glide.Glide;
import com.gdevs.myrecipe.Models.FavoriteRecipe;
import com.gdevs.myrecipe.Utils.Constant;
import com.gdevs.myrecipe.Utils.PrefManager;
import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;
import java.util.ArrayList;
import java.util.Arrays;

public class DetailsOfflineActivity extends AppCompatActivity {

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
    String recipeDesc;
    String recipeImage;
    String recipeType;
    String recipeVideo;
    String recipeId;
    String recipeCategoryName;
    String text;
    private Menu menu;
    int recipeIdInt;
    PrefManager prf;
    SwipeRefreshLayout swipeRefreshLayout;
    FloatingActionButton fab;

    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        prf = new PrefManager(this);

        Intent intent = getIntent();
        recipeIdInt = intent.getIntExtra("recipe_id",0);
        recipeName = intent.getStringExtra("recipeName");
        recipeTime = intent.getStringExtra("recipeTime");
        recipePerson = intent.getStringExtra("recipePerson");
        recipeDesc = intent.getStringExtra("recipeDesc");
        recipeImage = intent.getStringExtra("recipeImage");
        recipeType = intent.getStringExtra("recipeType");
        recipeVideo = intent.getStringExtra("recipeVideo");
        recipeId = intent.getStringExtra("recipeId");
        recipeCategoryName = intent.getStringExtra("recipeCategoryName");


        tvRecipeName = findViewById(R.id.tvRecipeName);
        ivRecipeImage = findViewById(R.id.ivRecipeImage);
        ivRecipeVideo = findViewById(R.id.ivRecipeVideo);
        tvRecipeTime = findViewById(R.id.tvRecipeTime);
        tvViews = findViewById(R.id.tvViews);
        tvRecipeCategory = findViewById(R.id.tvRecipeCategory);

        wvDesc = findViewById(R.id.wvDesc);
        rlMain = findViewById(R.id.rlMain);
        llParent = findViewById(R.id.llParent);

        swipeRefreshLayout = findViewById(R.id.swipeRefreshLayout);
        swipeRefreshLayout.setColorSchemeResources(R.color.black);

        getRecipeDetails();

        swipeRefreshLayout.setOnRefreshListener(this::refreshData);

    }

    private void getRecipeDetails() {

        rlMain.setVisibility(View.VISIBLE);
        showRefresh(false);

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

                    Glide.with(DetailsOfflineActivity.this)
                            .load(Config.ADMIN_PANEL_URL + "/images/" + recipeImage)
                            .placeholder(R.drawable.placeholder)
                            .centerCrop()
                            .into(ivRecipeImage);

                    if (recipeType.equals("video")){
                        ivRecipeVideo.setVisibility(View.VISIBLE);
                        ivRecipeImage.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                Intent intent = new Intent(getApplicationContext(), ActivityYoutubePlayer.class);
                                intent.putExtra("video_id", recipeVideo);
                                startActivity(intent);
                            }
                        });
                    }else {
                        ivRecipeVideo.setVisibility(View.INVISIBLE);
                        ivRecipeImage.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                Intent intent = new Intent(getApplicationContext(), ActivityFullSizeImage.class);
                                intent.putExtra("image_id", recipeImage);
                                startActivity(intent);
                            }
                        });
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

    private void isOffline() {
        Snackbar snackBar = Snackbar.make(llParent, "Please check Your Internet !", Snackbar.LENGTH_LONG);
        snackBar.setAction("Retry", new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showRefresh(true);
                refreshData();
            }
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
    public boolean onCreateOptionsMenu(final Menu menu) {

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
            getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR);
        }
    }

    @SuppressLint({"NonConstantResourceId", "UseCompatLoadingForDrawables"})
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

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
                    Toast.makeText(DetailsOfflineActivity.this, "Added to Favorite", Toast.LENGTH_SHORT).show();

                } else {
                    menu.getItem(1).setIcon(ContextCompat.getDrawable(getApplicationContext(), R.drawable.ic_baseline_favorite_border));
                    MainActivity.favoriteDatabase.favoriteDao().delete(favoriteList);
                    Toast.makeText(DetailsOfflineActivity.this, "Remove From Favorite", Toast.LENGTH_SHORT).show();
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