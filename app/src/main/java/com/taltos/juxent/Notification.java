package com.taltos.juxent;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.DividerItemDecoration;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.os.Bundle;

import com.taltos.juxent.models.Template_Notification;
import com.taltos.juxent.models.Template_Sale;
import com.taltos.juxent.recyclerviews.RecyclerView_Notification;
import com.taltos.juxent.recyclerviews.RecyclerView_Sale;

import java.util.ArrayList;
import java.util.List;

public class Notification extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.notification);

        recycler();
        query();
    }

    /** <span style="font-size: 50px; font-weight: bold;">RECYCLERVIEW</span> */
    RecyclerView recyclerView;
    RecyclerView_Notification recyclerView_notification;

    List<Template_Notification> list = new ArrayList<>();

    private void recycler() {
        recyclerView              = findViewById(R.id.recyclerView);
        recyclerView_notification = new RecyclerView_Notification(this, list);

        recyclerView.setLayoutManager(new LinearLayoutManager(this, LinearLayoutManager.VERTICAL, false));
        recyclerView.setHasFixedSize(false);
        recyclerView.setNestedScrollingEnabled(false);

        recyclerView.addItemDecoration(new DividerItemDecoration(this, LinearLayoutManager.VERTICAL));
        recyclerView.setAdapter(recyclerView_notification);
    }
    private void query() {
        //    Reset list
        list.clear();
        recyclerView_notification.notifyDataSetChanged();

        //    Temporary
        for (int i = 1; i <= 10; i++) {
            list.add(new Template_Notification(
                    "Notification " + i,
                    "Date"
            ));
            recyclerView_notification.notifyDataSetChanged();
        }
    }
}