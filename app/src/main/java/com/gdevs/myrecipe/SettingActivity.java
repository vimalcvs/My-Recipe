package com.gdevs.myrecipe;

import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.widget.LinearLayout;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import com.gdevs.myrecipe.Utils.PrefManager;
import com.google.android.material.switchmaterial.SwitchMaterial;

public class SettingActivity extends AppCompatActivity {

    LinearLayout privacyPolicy;
    LinearLayout aboutUs;
    LinearLayout shareApp;
    SwitchMaterial nightMode;
    SwitchMaterial gridMode;
    SwitchMaterial pushNotification;
    PrefManager prf;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_setting);



        prf = new PrefManager(this);

        nightMode = findViewById(R.id.nightMode);
        gridMode = findViewById(R.id.gridMode);
        pushNotification = findViewById(R.id.pushNotification);
        privacyPolicy = findViewById(R.id.privacyPolicy);
        aboutUs = findViewById(R.id.aboutUs);
        shareApp = findViewById(R.id.shareApp);

        //night
        nightMode.setOnCheckedChangeListener((compoundButton, isChecked) -> {
            if (isChecked){
                prf.setNightModeState(true);
                onResume();
            }else {
                prf.setNightModeState(false);
                onResume();
            }
        });

        //grid
        gridMode.setOnCheckedChangeListener((compoundButton, isChecked) -> {
            if (isChecked){
                prf.setString("grid","true");
            }else {
                prf.setString("grid","false");
            }
        });


        //privacy
        privacyPolicy.setOnClickListener(v -> startActivity(new Intent(SettingActivity.this,PrivacyPolicyActivity.class)));

        //about
        aboutUs.setOnClickListener(v -> {

        });

        //share
        shareApp.setOnClickListener(v -> {
            Intent intent = new Intent(Intent.ACTION_SEND);
            intent.setType("text/plain");
            String shareBodyText = "https://play.google.com/store/apps/details?id="+getPackageName();
            intent.putExtra(Intent.EXTRA_SUBJECT,getString(R.string.app_name));
            intent.putExtra(Intent.EXTRA_TEXT,shareBodyText);
            startActivity(Intent.createChooser(intent,"share via"));
        });
    }

    @Override
    public void onResume() {
        super.onResume();
        initCheck();
        checkStyle();
    }

    private void checkStyle() {
        gridMode.setChecked(prf.getString("grid").equals("true"));
    }

    private void initCheck() {
        if (prf.loadNightModeState()){
            nightMode.setChecked(true);
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
        }else {
            nightMode.setChecked(false);
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
        }
    }


    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        if (item.getItemId() == android.R.id.home) {
            this.finish();
        }
        return true;
    }
}