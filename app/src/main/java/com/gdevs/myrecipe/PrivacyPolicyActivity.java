package com.gdevs.myrecipe;

import android.os.Build;
import android.os.Bundle;
import android.text.Html;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.toolbox.JsonObjectRequest;
import com.facebook.ads.AdSettings;
import com.gdevs.myrecipe.Utils.Constant;
import com.gdevs.myrecipe.Utils.PrefManager;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdSize;
import com.google.android.gms.ads.AdView;

import org.json.JSONException;

public class PrivacyPolicyActivity extends AppCompatActivity {

    TextView textView;
    ProgressBar relativeLayoutLoadMore;
    PrefManager prf;

    @Override
    protected void onCreate (Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_privacy_policy);

        prf = new PrefManager(this);

        if (prf.getString(Config.ADS).equals("true")){
            loadBannerAds();
        }else {
            Log.d("OFF","ADS");
        }

        textView = findViewById(R.id.textView);

        relativeLayoutLoadMore = findViewById(R.id.relativeLayoutLoadMore);
        relativeLayoutLoadMore.setVisibility(View.VISIBLE);
        getPrivacyPolicy();
        initCheck();

    }

    private void getPrivacyPolicy() {

        JsonObjectRequest jsonObjReq = new JsonObjectRequest(Request.Method.GET, Constant.URL_PRIVACY_POLICY, null, response -> {
            relativeLayoutLoadMore.setVisibility(View.GONE);
            try {
                final String result = response.getString("app_privacy_policy");
                textView.setText(Html.fromHtml(result));

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

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // handle arrow click here
        if (item.getItemId() == android.R.id.home) {
            finish(); // close this activity and return to preview activity (if there is any)
        }
        return super.onOptionsItemSelected(item);
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