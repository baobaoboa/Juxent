package com.taltos.juxent.extensions;

import android.app.Activity;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.recyclerview.widget.RecyclerView;

import com.google.android.material.bottomsheet.BottomSheetBehavior;
import com.google.android.material.checkbox.MaterialCheckBox;
import com.taltos.juxent.R;
import com.taltos.juxent.models.Template_Sale;

import java.util.ArrayList;
import java.util.List;

public class RecyclerView_Sale extends RecyclerView.Adapter<RecyclerView_Sale.MyViewHolder> {

    private Activity mContext;
    private List<Template_Sale> mData;

    public boolean clicked      = false;
    public List<String> checked = new ArrayList<>();
    public boolean selected     = false;
    public boolean selectedAll  = false;

    private BottomSheetBehavior bottomSheetBehavior;
    private RecyclerView recyclerView;

    public RecyclerView_Sale(Activity mContext, List<Template_Sale> mData, RecyclerView recyclerView) {
        this.mContext = mContext;
        this.mData = mData;
        this.recyclerView = recyclerView;

        //    Bottom Sheet
        View bottomSheet    = mContext.findViewById(R.id.bottomSheet);
        bottomSheetBehavior = BottomSheetBehavior.from(bottomSheet);
    }

    @Override
    public MyViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(mContext).inflate(R.layout.template_sale, parent, false);
        return new MyViewHolder(view).linkAdapter(this, mContext);
    }

    @Override
    public void onBindViewHolder(MyViewHolder holder, int position) {
        //    If select or deselect is clicked
        if (clicked) {
            if (!selectedAll) {
                selected = false;
            }
            holder.checkBox.setChecked(selectedAll);
        }

        //    If one or more is selected
        if (selected) {
            recyclerView.setPadding(0,0,0, (int) mContext.getResources().getDimension(R.dimen.default_padding_margin_colossal));

            holder.checkBox.setVisibility(View.VISIBLE);
            bottomSheetBehavior.setState(BottomSheetBehavior.STATE_EXPANDED);
        } else {
            recyclerView.setPadding(0,0,0, 0);

            holder.checkBox.setVisibility(View.GONE);
            bottomSheetBehavior.setState(BottomSheetBehavior.STATE_HIDDEN);
        }

        //    Open report if clicked
        holder.layout.setOnClickListener(view -> {

        });

        //    Reveal checkboxes if long pressed
        holder.layout.setOnLongClickListener(view -> {
            holder.checkBox.setChecked(true);

            selected = true;
            notifyDataSetChanged();

            return false;
        });

        //    Changes whenever checkbox is pressed
        holder.checkBox.setOnCheckedChangeListener((compoundButton, b) -> {
            if (b) {
                checked.add(mData.get(position).getId());
            } else {
                checked.remove(mData.get(position).getId());
            }
            ((TextView) mContext.findViewById(R.id.tv_Selected)).setText(String.valueOf(checked.size()));

            if (checked.isEmpty() && !clicked) {
                selected = false;
                notifyDataSetChanged();
            }
        });

        if (getItemCount() == position + 1) {
            clicked = false;
        }

        //    Changing the values of the holders
        String id = String.format("%06d", Integer.parseInt(mData.get(position).getId()));
        String warrantyStatus = mData.get(position).getWarrantyStatus() + ", " + mData.get(position).getDaysRemaining() + " Days";

        holder.id.setText(id);
        holder.productPurchased.setText(mData.get(position).getProductPurchased());
        holder.softwareType.setText(mData.get(position).getSoftwareType());
        holder.warrantyStatus.setText(warrantyStatus);
        holder.date.setText(mData.get(position).getDate());
    }

    @Override
    public int getItemCount() {
        return mData.size();
    }

    public static class MyViewHolder extends RecyclerView.ViewHolder {
        RecyclerView_Sale adapter;
        Activity mContext;

        LinearLayout layout;
        MaterialCheckBox checkBox;
        TextView id, productPurchased, softwareType, warrantyStatus, date;

        public MyViewHolder(View itemView) {
            super(itemView);

            layout   = itemView.findViewById(R.id.linearLayout);
            checkBox = itemView.findViewById(R.id.checkBox);

            id               = itemView.findViewById(R.id.tv_Id);
            productPurchased = itemView.findViewById(R.id.tv_ProductPurchased);
            softwareType     = itemView.findViewById(R.id.tv_SoftwareType);
            warrantyStatus   = itemView.findViewById(R.id.tv_WarrantyStatus);
            date             = itemView.findViewById(R.id.tv_Date);
        }

        public MyViewHolder linkAdapter(RecyclerView_Sale adapter, Activity mContext) {
            this.adapter = adapter;
            this.mContext = mContext;
            return this;
        }
    }

    // Download
    public void SelectAll() {
        clicked     = true;
        selectedAll = true;

        notifyDataSetChanged();
    }
    public void DeselectAll() {
        Toast.makeText(mContext, "WORKS", Toast.LENGTH_SHORT).show();
        clicked     = true;
        selectedAll = false;

        notifyDataSetChanged();
    }
}
