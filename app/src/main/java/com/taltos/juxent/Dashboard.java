package com.taltos.juxent;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

public class Dashboard extends Fragment {

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        //    Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.dashboard, container, false);
        return view;
    }
}