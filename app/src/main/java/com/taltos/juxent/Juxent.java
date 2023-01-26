package com.taltos.juxent;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.annotation.SuppressLint;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.navigation.NavigationView;

@SuppressLint("NonConstantResourceId")
public class Juxent extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.juxent);
        navigationDrawer();
    }

    /** <span style="font-size: 50px; font-weight: bold;">SIDEBAR</span> */
    DrawerLayout drawerLayout;
    NavigationView navigationView;

    TextView user, position;

    View bottomSheet;
    BottomSheetBehavior bottomSheetBehavior;

    private void navigationDrawer() {
        drawerLayout   = findViewById(R.id.drawer_layout);
        navigationView = findViewById(R.id.navigation_view);
        user           = navigationView.getHeaderView(0).findViewById(R.id.tv_Name);
        position       = navigationView.getHeaderView(0).findViewById(R.id.tv_CompanyPosition);

        bottomSheet    = findViewById(R.id.bottomSheet);
        bottomSheetBehavior = BottomSheetBehavior.from(bottomSheet);

        MaterialToolbar toolbar = findViewById(R.id.toolbar);
        toolbar.setNavigationOnClickListener(view -> drawerLayout.openDrawer(GravityCompat.START));

        replaceFragment(new Dashboard());

        findViewById(R.id.btn_Back).setOnClickListener(view -> drawerLayout.closeDrawers());
        findViewById(R.id.btn_Notification).setOnClickListener(view -> Toast.makeText(this, "Notification", Toast.LENGTH_SHORT).show());

        navigationView.setNavigationItemSelectedListener(menuItem -> {
            //    Close drawer
            drawerLayout.closeDrawers();

            if (!menuItem.isChecked()) {
                bottomSheetBehavior.setState(BottomSheetBehavior.STATE_HIDDEN);
                menuItem.setChecked(true);

                //    Swapping fragments happen here
                switch (menuItem.getItemId()) {
                    case R.id.Dashboard:
                        replaceFragment(new Dashboard());
                        break;

                    case R.id.Profile:
                        replaceFragment(new Profile());
                        break;

                    case R.id.Teams:
                        replaceFragment(new Teams());
                        break;

                    case R.id.Sales_Report:
                        replaceFragment(new Sales_Report());
                        break;

                    case R.id.Warranty:
                        replaceFragment(new Warranty());
                        break;

                    case R.id.Reported_Issue:
                        replaceFragment(new Reported_Issue());
                        break;

                    case R.id.Download:
                        replaceFragment(new Download());
                        break;
                }
            }

            return true;
        });
    }
    private void replaceFragment(Fragment fragment) {
        FragmentManager fragmentManager         = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();

        fragmentTransaction.replace(R.id.frameLayout, fragment);
        fragmentTransaction.commit();
    }
}