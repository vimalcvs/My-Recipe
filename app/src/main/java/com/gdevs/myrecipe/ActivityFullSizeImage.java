package com.gdevs.myrecipe;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;

import com.bumptech.glide.Glide;
import com.gdevs.myrecipe.Utils.PrefManager;

public class ActivityFullSizeImage extends AppCompatActivity {

    ImageView photoView;
    String imageId;
    PrefManager prf;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_full_size_image);


        prf = new PrefManager(this);

        Window window = getWindow();
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LAYOUT_FULLSCREEN);
        window.setStatusBarColor(Color.TRANSPARENT);

        Intent intent = getIntent();
        imageId = intent.getStringExtra("image_id");

        photoView = findViewById(R.id.photo_view);

        Glide.with(this)
                .load(Config.ADMIN_PANEL_URL + "/images/" + imageId)
                .placeholder(R.drawable.placeholder)
                .into(photoView);


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
            getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_LIGHT_STATUS_BAR);   // set status text dark
        }
    }
}