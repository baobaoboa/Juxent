package com.taltos.juxent;

import android.content.Intent;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.taltos.juxent.forms.Form_Teams;

public class Teams extends Fragment {

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.teams, container, false);

        syluxent(view);

        return view;
    }

    /** <span style="font-size: 50px; font-weight: bold;">SYLUXENT</span> */
    private void syluxent(View view) {
        view.findViewById(R.id.btn_Add).setOnClickListener(v -> startActivity(new Intent(getActivity(), Form_Teams.class)));
    }
}