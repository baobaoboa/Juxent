package com.taltos.juxent;

import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.core.view.GravityCompat;
import androidx.core.widget.NestedScrollView;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.github.dewinjm.monthyearpicker.MonthYearPickerDialogFragment;
import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.navigation.NavigationView;
import com.google.android.material.tabs.TabLayout;
import com.prolificinteractive.materialcalendarview.CalendarDay;
import com.prolificinteractive.materialcalendarview.CalendarMode;
import com.prolificinteractive.materialcalendarview.MaterialCalendarView;
import com.taltos.juxent.extensions.RecyclerView_Sale;
import com.taltos.juxent.models.Template_Sale;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

public class Sales_Report extends Fragment {

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.sales_report, container, false);

        calendar(view);
        recycler(view);

        return view;
    }

    /** <span style="font-size: 50px; font-weight: bold;">CALENDAR</span> */
    TabLayout tabLayout;

    View bottomSheet;
    BottomSheetBehavior bottomSheetBehavior;

    MaterialCalendarView calendarView;
    MonthYearPickerDialogFragment dialogFragment;

    Integer minYear = 2000, minMonth = 1, minDay = 1;

    String calendarMethod = "Month";
    Integer selectedYear = 0, selectedMonth = 0, selectedDay = 0;

    private void calendar(View view) {
        calendarView = view.findViewById(R.id.calendarView);
        tabLayout    = view.findViewById(R.id.tabLayout);

        bottomSheet    = getActivity().findViewById(R.id.bottomSheet);
        bottomSheetBehavior = BottomSheetBehavior.from(bottomSheet);

        tabLayout.addOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {
            @Override
            public void onTabSelected(TabLayout.Tab tab) {
                resetCalendar();

                //    Get tab position
                if (tab.getPosition() == 0) {
                    tab(view, 0);
                } else {
                    tab(view, 1);
                }
            }

            @Override
            public void onTabUnselected(TabLayout.Tab tab) {}
            @Override
            public void onTabReselected(TabLayout.Tab tab) {}
        });

        //    Modify parameters from current state
        calendarView.state().edit()
                .setMinimumDate(CalendarDay.from(minYear, minMonth, minDay))
                .setMaximumDate(CalendarDay.today())
                .setCalendarDisplayMode(CalendarMode.MONTHS)
                .commit();

        //    Set default
        tab(view, 0);
    }
    private void tab(View view, Integer tab) {
        if (tab.equals(0)) {
            calendarView.setSelectionMode(MaterialCalendarView.SELECTION_MODE_SINGLE);

            //    Sets the listener to be notified upon selected date changes
            calendarView.setOnDateChangedListener((widget, date, selected) -> {
                resetCalendar();

                if (date.getDay() == selectedDay) {
                    calendarView.clearSelection();
                    calendarMethod = "Month";
                } else {
                    selectedDay    = date.getDay();
                    calendarMethod = "Day";
                }

                query();
            });

            //    Sets the listener to be notified upon month changes
            calendarView.setOnMonthChangedListener((widget, date) -> {
                resetCalendar();
                calendarView.clearSelection();

                selectedYear  = date.getYear();
                selectedMonth = date.getMonth();

                calendarMethod = "Month";
                query();
            });

            //    Sets the listener to be notified upon clicking title
            calendarView.setOnTitleClickListener(v -> {
                Calendar calendar = Calendar.getInstance();
                calendar.clear();
                calendar.set(minYear, (minMonth - 1), minDay);

                long minDate = calendar.getTimeInMillis();
                long maxDate = System.currentTimeMillis();

                Log.i("DATE", new Date(maxDate).toString());

                dialogFragment = MonthYearPickerDialogFragment.getInstance((selectedMonth - 1), selectedYear, minDate, maxDate);
                dialogFragment.show(getChildFragmentManager(), null);

                dialogFragment.setOnDateSetListener((year, monthOfYear) -> {
                    if (!selectedMonth.equals(monthOfYear + 1)) {
                        selectedYear = year;
                        selectedMonth = monthOfYear + 1;
                        calendarView.setCurrentDate(CalendarDay.from(selectedYear, selectedMonth, 1));
                    }
                });
            });
        } else {
            calendarView.setSelectionMode(MaterialCalendarView.SELECTION_MODE_RANGE);

            //    Sets the listener to be notified upon selected date changes
            calendarView.setOnDateChangedListener((widget, date, selected) -> {
                resetCalendar();
            });

            calendarView.setOnRangeSelectedListener((widget, dates) -> {
                query();
            });
        }
    }
    private void resetCalendar() {
        //    Reset bottom sheet
        bottomSheetBehavior.setState(BottomSheetBehavior.STATE_HIDDEN);

        //    Reset checked
        getActivity().findViewById(R.id.btn_DeselectAll).performClick();

        //    Reset list
        list.clear();
        recyclerView_sale.notifyDataSetChanged();

        //    Reset day
        selectedDay   = 0;
    }

    /** <span style="font-size: 50px; font-weight: bold;">RECYCLERVIEW</span> */
    RecyclerView recyclerView;
    RecyclerView_Sale recyclerView_sale;

    List<Template_Sale> list = new ArrayList<>();

    private void recycler(View view) {
        getActivity().findViewById(R.id.btn_SelectAll).setOnClickListener(v -> recyclerView_sale.SelectAll());
        getActivity().findViewById(R.id.btn_DeselectAll).setOnClickListener(v -> recyclerView_sale.DeselectAll());

        recyclerView      = view.findViewById(R.id.recyclerView);
        recyclerView_sale = new RecyclerView_Sale(getActivity(), list, recyclerView);

        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity(), LinearLayoutManager.VERTICAL, false));
        recyclerView.setHasFixedSize(false);
        recyclerView.setNestedScrollingEnabled(false);

        recyclerView.addItemDecoration(new DividerItemDecoration(getActivity(), LinearLayoutManager.VERTICAL));
        recyclerView.setAdapter(recyclerView_sale);
    }
    private void query() {
        //    Reset list
        list.clear();
        recyclerView_sale.notifyDataSetChanged();

        //    Temporary
        for (int i = 1; i <= 5; i++) {
            list.add(new Template_Sale(
                    i + "",
                    "Product Purchased",
                    "Software Type",
                    "Warranty Status",
                    100L,
                    "Date"
            ));
            recyclerView_sale.notifyDataSetChanged();
        }
    }
}