package com.taltos.juxent;

import android.annotation.SuppressLint;
import android.os.Bundle;

import androidx.core.content.res.ResourcesCompat;
import androidx.fragment.app.Fragment;
import androidx.viewpager2.widget.ViewPager2;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;

import com.google.android.material.tabs.TabLayout;
import com.taltos.juxent.extensions.Adapter_ViewPager;

@SuppressLint("InflateParams")
public class Download extends Fragment {

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.download, container, false);

        tabLayout(view);

        return view;
    }

    /** <span style="font-size: 50px; font-weight: bold;">DOWNLOAD</span> */
    Adapter_ViewPager adapter_viewPager;
    TabLayout tl_Downloads;
    ViewPager2 viewPager2;

    View view_Issue, view_Sale, view_Warranty;
    ImageView iv_Issue, iv_Sale, iv_Warranty;

    private void tabLayout(View view) {
        tl_Downloads = view.findViewById(R.id.tl_Download);
        viewPager2   = view.findViewById(R.id.vp_Download);

        view_Issue    = getLayoutInflater().inflate(R.layout.template_download, null);
        view_Sale     = getLayoutInflater().inflate(R.layout.template_download, null);
        view_Warranty = getLayoutInflater().inflate(R.layout.template_download, null);

        iv_Issue    = view_Issue.findViewById(R.id.iv_Icon);
        iv_Sale     = view_Sale.findViewById(R.id.iv_Icon);
        iv_Warranty = view_Warranty.findViewById(R.id.iv_Icon);

//        adapter_viewPager = new Adapter_ViewPager(getActivity(), "Downloads");

        iv_Issue.setImageDrawable(ResourcesCompat.getDrawable(getResources(),
                R.drawable.issue_download, null));
        iv_Sale.setImageDrawable(ResourcesCompat.getDrawable(getResources(),
                R.drawable.sales_download, null));
        iv_Warranty.setImageDrawable(ResourcesCompat.getDrawable(getResources(),
                R.drawable.warranty_download, null));

        tl_Downloads.addTab(tl_Downloads.newTab().setCustomView(iv_Sale));
        tl_Downloads.addTab(tl_Downloads.newTab().setCustomView(iv_Warranty));
        tl_Downloads.addTab(tl_Downloads.newTab().setCustomView(iv_Issue));

//        viewPager2.setAdapter(adapter_viewPager);
    }
}