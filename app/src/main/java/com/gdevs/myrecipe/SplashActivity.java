package com.gdevs.myrecipe;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import com.android.volley.Request;
import com.android.volley.toolbox.JsonObjectRequest;
import com.gdevs.myrecipe.Utils.Constant;
import com.gdevs.myrecipe.Utils.PrefManager;

import org.json.JSONException;

import java.util.Timer;
import java.util.TimerTask;

public class SplashActivity extends AppCompatActivity {
    PrefManager prf;
    @Override
    protected void onCreate (Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_splash);
        prf = new PrefManager(this);

        initCheck();
        getAllData();

        Timer myTimer = new Timer();
        myTimer.schedule(new TimerTask() {
            @Override
            public void run() {
                SplashActivity.this.runOnUiThread(() -> {
                    startActivity(new Intent(SplashActivity.this,MainActivity.class));
                    finish();

                });
            }
        }, 3000);
    }

    private void getAllData() {

        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET, Constant.URL_LOAD_DATA, null, response -> {
            try {
                final String ads_status = response.getString("ads_status");
                final String ads_type = response.getString("ads_type");
                final String admob_banner = response.getString("admob_banner");
                final String admob_inter = response.getString("admob_inter");
                final String facebook_banner = response.getString("facebook_banner");
                final String facebook_inter = response.getString("facebook_inter");

                prf.setString("ADS", ads_status);
                prf.setString(Config.ADS_NETWORK,ads_type);
                prf.setString(Config.ADMOB_BANNER_ID,admob_banner);
                prf.setString(Config.ADMOB_INTER_ID,admob_inter);
                prf.setString(Config.FACEBOOK_BANNER_ID,facebook_banner);
                prf.setString(Config.FACEBOOK_INTER_ID,facebook_inter);

            } catch (JSONException e) {
                e.printStackTrace();
            }
        }, error -> {
        });
        MyApplication.getInstance().addToRequestQueue(jsonObjReq);
    }

    private void initCheck() {
        if (prf.loadNightModeState()){
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_YES);
        }else {
            AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
        }
        Log.d("TAG","OK");
    }
}