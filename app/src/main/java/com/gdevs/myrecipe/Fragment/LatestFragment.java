package com.gdevs.myrecipe.Fragment;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.os.Handler;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;
import android.widget.RelativeLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.android.volley.Request;
import com.android.volley.toolbox.JsonArrayRequest;
import com.gdevs.myrecipe.Adapter.AdapterRecipe;
import com.gdevs.myrecipe.Models.Recipe;
import com.gdevs.myrecipe.MyApplication;
import com.gdevs.myrecipe.R;
import com.gdevs.myrecipe.Utils.Constant;
import com.gdevs.myrecipe.Utils.Methods;
import com.gdevs.myrecipe.Utils.PrefManager;
import com.google.android.material.snackbar.Snackbar;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

@SuppressLint("NotifyDataSetChanged")
public class LatestFragment extends Fragment {

    SwipeRefreshLayout swipeRefreshLayout = null;
    RecyclerView recyclerView;
    RelativeLayout lyt_parent;
    private String lastId = "0";
    private boolean itShouldLoadMore = true;
    private AdapterRecipe mAdapter;
    private ArrayList<Recipe> arrayList;
    ProgressBar progressBar;
    View lyt_no_item;
    Methods methods;
    PrefManager prf;


    public LatestFragment() {

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);

        lyt_parent = view.findViewById(R.id.lyt_parent);
        lyt_no_item = view.findViewById(R.id.lyt_no_item);

        methods = new Methods(getActivity());
        prf = new PrefManager(requireActivity());

        swipeRefreshLayout = view.findViewById(R.id.swipeRefreshLayout);
        swipeRefreshLayout.setColorSchemeResources(R.color.black);
        showRefresh(true);

        progressBar = view.findViewById(R.id.progressBar);

        arrayList = new ArrayList<>();
        mAdapter = new AdapterRecipe(getActivity(), arrayList);

        recyclerView = view.findViewById(R.id.recyclerView);

        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
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


        return view;
    }

    private void firstLoadData() {
        if (methods.isNetworkAvailable()) {
            itShouldLoadMore = false;


            JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, Constant.URL_RECENT_RECIPE, null, response -> {

                showRefresh(false);
                itShouldLoadMore = true;

                if (response.length() <= 0) {
                    lyt_no_item.setVisibility(View.VISIBLE);
                    return;
                }

                for (int i = 0; i < response.length(); i++) {
                    try {
                        JSONObject jsonObject = response.getJSONObject(i);

                        lastId = jsonObject.getString(Constant.NO);
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
            mAdapter = new AdapterRecipe(getContext(), arrayList);
            recyclerView.setAdapter(mAdapter);
        }

    }

    private void loadMore() {

        itShouldLoadMore = false;
        progressBar.setVisibility(View.VISIBLE);

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, Constant.URL_RECENT_RECIPE + lastId, null, response -> new Handler().postDelayed(() -> {

            showRefresh(false);
            progressBar.setVisibility(View.GONE);
            itShouldLoadMore = true;

            if (response.length() <= 0) {
                return;
            }

            for (int i = 0; i < response.length(); i++) {
                try {
                    JSONObject jsonObject = response.getJSONObject(i);

                    lastId = jsonObject.getString(Constant.NO);
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

        lyt_no_item.setVisibility(View.GONE);
        arrayList.clear();
        mAdapter.notifyDataSetChanged();
        new Handler().postDelayed(this::firstLoadData, Constant.DELAY_REFRESH);

    }

    private void isOffline() {
        Snackbar snackBar = Snackbar.make(lyt_parent, "msg_offline", Snackbar.LENGTH_LONG);
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
            new Handler().postDelayed(() -> swipeRefreshLayout.setRefreshing(false), Constant.DELAY_PROGRESS);
        }
    }

    @Override
    public void onResume() {
        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        recyclerView.setHasFixedSize(true);
        recyclerView.setAdapter(mAdapter);
        super.onResume();
    }
}