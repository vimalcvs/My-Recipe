package com.gdevs.myrecipe.Utils;

import android.content.Context;
import android.content.SharedPreferences;

public class PrefManager {

    private static final String PREF_NAME = "status_app";

    Context _context;
    SharedPreferences.Editor editor;
    SharedPreferences pref;

    public PrefManager(Context context) {
        this._context = context;
        SharedPreferences sharedPreferences = context.getSharedPreferences(PREF_NAME, 0);
        this.pref = sharedPreferences;
        this.editor = sharedPreferences.edit();
    }

    public String getPath() {
        return this.pref.getString("path", "0");
    }


    public void setString(String str, String str2) {
        this.editor.putString(str, str2);
        this.editor.commit();
    }

    public String getString(String str) {
        return this.pref.contains(str) ? this.pref.getString(str, "Default") : "";
    }

    public int getInt(String str) {
        return this.pref.getInt(str, 0);
    }


    //save
    public void setNightModeState(Boolean state){
        SharedPreferences.Editor editor= pref.edit();
        editor.putBoolean("NightMode",state);
        editor.apply();
    }

    //load
    public Boolean loadNightModeState(){
        return pref.getBoolean("NightMode",false);
    }

}
