package com.taltos.juxent.recyclerviews;

import android.app.Activity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.taltos.juxent.R;
import com.taltos.juxent.models.Template_Notification;

import java.util.List;

public class RecyclerView_Notification extends RecyclerView.Adapter<RecyclerView_Notification.MyViewHolder> {

    private Activity mContext;
    private List<Template_Notification> mData;

    public RecyclerView_Notification(Activity mContext, List<Template_Notification> mData) {
        this.mContext = mContext;
        this.mData    = mData;
    }

    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(mContext).inflate(R.layout.template_notification, parent, false);
        return new MyViewHolder(view).linkAdapter(this, mContext);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        holder.notification.setText(mData.get(position).getNotification());
        holder.date.setText(mData.get(position).getDate());
    }

    @Override
    public int getItemCount() {
        return mData.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder {
        RecyclerView_Notification adapter;
        Activity mContext;

        LinearLayout layout;
        TextView notification, date;

        public MyViewHolder(View itemView) {
            super(itemView);

            layout = itemView.findViewById(R.id.linearLayout);

            notification = itemView.findViewById(R.id.tv_Notification);
            date         = itemView.findViewById(R.id.tv_Date);
        }

        public MyViewHolder linkAdapter(RecyclerView_Notification adapter, Activity mContext) {
            this.adapter  = adapter;
            this.mContext = mContext;
            return this;
        }
    }
}
