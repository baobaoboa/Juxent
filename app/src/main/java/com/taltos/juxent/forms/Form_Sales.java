package com.taltos.juxent.forms;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.bumptech.glide.Glide;
import com.github.dhaval2404.imagepicker.ImagePicker;
import com.google.android.material.datepicker.CalendarConstraints;
import com.google.android.material.datepicker.DateValidatorPointBackward;
import com.google.android.material.datepicker.MaterialDatePicker;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;
import com.google.android.material.imageview.ShapeableImageView;
import com.google.android.material.textfield.MaterialAutoCompleteTextView;
import com.google.android.material.textfield.TextInputEditText;
import com.taltos.juxent.R;

import java.text.DecimalFormat;
import java.util.Objects;

public class Form_Sales extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.form_sales);

        sale();
        datePicker();
        dialog();
//        Method(getIntent().getStringExtra("METHOD"), getIntent().getStringExtra("ID"));
    }

    /** <span style="font-size: 50px; font-weight: bold;">METHOD</span> */
    String companyPosition;
    Integer lastSale;

    private void Method(String method, String saleID) {
        if (method.equalsIgnoreCase("VIEW")) {
            findViewById(R.id.btn_Create).setVisibility(View.GONE);
            get(saleID);

            tiet_ORSI.setOnClickListener(view -> view(tiet_ORSI));
            tiet_AR.setOnClickListener(view -> view(tiet_AR));

            tiet_ORSI.setText("View Image");
            tiet_AR.setText("View Image");

            if (companyPosition.equalsIgnoreCase("Sales Consultant") || companyPosition.equalsIgnoreCase("Operations Manager")) {
                findViewById(R.id.btn_Edit).setVisibility(View.VISIBLE);
                ((Button) findViewById(R.id.btn_Create)).setText("Edit Sale");

//                findViewById(R.id.btn_Edit).setOnClickListener(view -> Edit(saleID));
//                findViewById(R.id.btn_Cancel).setOnClickListener(view -> Cancel(saleID));
//                findViewById(R.id.btn_Create).setOnClickListener(view -> EditSale(saleID));
            }
        } else {
            findViewById(R.id.btn_Create).getLayoutParams().width = 0;
            findViewById(R.id.btn_Create).setOnClickListener(view -> create());

            tiet_ORSI.setOnClickListener(view -> upload(tiet_ORSI));
            tiet_AR.setOnClickListener(view -> upload(tiet_AR));

            // Set SF Id.
            String formattedId = String.format("%06d", Integer.parseInt(saleID));
            tv_Id.setText("SF 00-" + formattedId);

            lastSale = Integer.parseInt(saleID);
        }
    }

    /** <span style="font-size: 50px; font-weight: bold;">EMPLOYEE</span> */
    TextView tv_Id;

    MaterialAutoCompleteTextView actv_SoftwareType;
    TextInputEditText tiet_Client, tiet_CompanyAddress, tiet_ContactPerson, tiet_PhoneNumber, tiet_AmountPaid,
            tiet_DatePaid, tiet_DateDelivered, tiet_ORSI, tiet_AR;

    private void sale() {
        //    Setting up components
        tv_Id = findViewById(R.id.tv_Id);

        actv_SoftwareType   = findViewById(R.id.actv_SoftwareType);
        tiet_Client         = findViewById(R.id.tiet_Client);
        tiet_CompanyAddress = findViewById(R.id.tiet_CompanyAddress);
        tiet_ContactPerson  = findViewById(R.id.tiet_ContactPerson);
        tiet_PhoneNumber    = findViewById(R.id.tiet_PhoneNumber);
        tiet_AmountPaid     = findViewById(R.id.tiet_AmountPaid);
        tiet_DatePaid       = findViewById(R.id.tiet_DatePaid);
        tiet_DateDelivered  = findViewById(R.id.tiet_DateDelivered);
        tiet_ORSI           = findViewById(R.id.tiet_ORSI);
        tiet_AR             = findViewById(R.id.tiet_AR);

        //    Setting up values



        //    Adding listeners to components
        findViewById(R.id.btn_Exit).setOnClickListener(view -> onBackPressed());
        findViewById(R.id.btn_Create).setOnClickListener(view -> create());

        tiet_DatePaid.setOnClickListener(view -> datePickerDialog(tiet_DatePaid));
        tiet_DateDelivered.setOnClickListener(view -> datePickerDialog(tiet_DateDelivered));
        tiet_ORSI.setOnClickListener(view -> dialog_ORSI.show());
        tiet_AR.setOnClickListener(view -> dialog_AR.show());
    }
    private void get(String saleID) {
        //    Variables
        {
            //    Set Id
            String formattedId = String.format("%06d", Integer.parseInt(saleID));
            tv_Id.setText("SF 00-" + formattedId);

            //    Changing toggle of components
            findViewById(R.id.til_SoftwareType).setEnabled(false);
            actv_SoftwareType.setEnabled(false);
            tiet_Client.setEnabled(false);
            tiet_CompanyAddress.setEnabled(false);
            tiet_ContactPerson.setEnabled(false);
            tiet_PhoneNumber.setEnabled(false);
            tiet_AmountPaid.setEnabled(false);
            tiet_DatePaid.setEnabled(false);
            tiet_DateDelivered.setEnabled(false);
        }

        //    Module
        {
            //    Add progress dialog [Loading]
            ProgressDialog progressDialog = new ProgressDialog(this);
            progressDialog.setMessage("Getting Information");
            progressDialog.setCancelable(false);
            progressDialog.show();

            DecimalFormat formatter = new DecimalFormat("###,###,###,###.00");

            //    Get document `saleID` from `sale`
            //    Collection == table name
            //    Document   == row
        }
    }
    private void create() {
        // Save inputs
        final String softwareType       = actv_SoftwareType.getText().toString();
        final String client             = tiet_Client.getText().toString();
        final String companyAddress     = tiet_CompanyAddress.getText().toString();
        final String contactPerson      = tiet_ContactPerson.getText().toString();
        final String phoneNumber        = tiet_PhoneNumber.getText().toString();
        final String amountPaid         = tiet_AmountPaid.getText().toString();
        final String str_date_paid      = tiet_DatePaid.getText().toString();
        final String str_date_delivered = tiet_DateDelivered.getText().toString();

        // Validate inputs
        {
            if (TextUtils.isEmpty(softwareType)) {
                actv_SoftwareType.setError("Please choose software type");
                actv_SoftwareType.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(client)) {
                tiet_Client.setError("Please enter client");
                tiet_Client.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(companyAddress)) {
                tiet_CompanyAddress.setError("Please enter company address");
                tiet_CompanyAddress.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(contactPerson)) {
                tiet_ContactPerson.setError("Please enter contact person");
                tiet_ContactPerson.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(phoneNumber)) {
                tiet_PhoneNumber.setError("Please enter phone number");
                tiet_PhoneNumber.requestFocus();

                return;
            }
            if (phoneNumber.length() < 10) {
                tiet_PhoneNumber.setError("Please number should be 10 digits (+63 excluded)");
                tiet_PhoneNumber.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(amountPaid)) {
                tiet_AmountPaid.setError("Please enter amount paid");
                tiet_AmountPaid.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(str_date_paid)) {
                tiet_DatePaid.setError("Please enter date paid");
                tiet_DatePaid.requestFocus();

                return;
            }
            if (Objects.isNull(iv_ORSI.getTag())) {
                tiet_ORSI.setError("Please insert a proof of Official Receipt / Sales Invoice");
                tiet_ORSI.requestFocus();

                return;
            }
            if (Objects.isNull(iv_AR.getTag())) {
                tiet_AR.setError("Please insert a proof of Acknowledgement Receipt");
                tiet_AR.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(str_date_delivered)) {
                tiet_DateDelivered.setError("Please enter date delivered");
                tiet_DateDelivered.requestFocus();

                return;
            }
        }
    }
    private void editSale(String saleID) {
        isEdit = false;

        //    Save inputs
        final String softwareType       = actv_SoftwareType.getText().toString();
        final String client             = tiet_Client.getText().toString();
        final String companyAddress     = tiet_CompanyAddress.getText().toString();
        final String contactPerson      = tiet_ContactPerson.getText().toString();
        final String phoneNumber        = tiet_PhoneNumber.getText().toString();
        final String amountPaid         = tiet_AmountPaid.getText().toString();
        final String str_date_paid      = tiet_DatePaid.getText().toString();
        final String str_date_delivered = tiet_DateDelivered.getText().toString();
    }
    private void edit(String saleID) {
        isEdit = true;

        tiet_ORSI.setOnClickListener(view -> upload(tiet_ORSI));
        tiet_AR.setOnClickListener(view -> upload(tiet_AR));

        //    Changing toggle of components
        findViewById(R.id.til_SoftwareType).setEnabled(true);
        actv_SoftwareType.setEnabled(true);
        tiet_Client.setEnabled(true);
        tiet_CompanyAddress.setEnabled(true);
        tiet_ContactPerson.setEnabled(true);
        tiet_PhoneNumber.setEnabled(true);
        tiet_AmountPaid.setEnabled(true);
        tiet_DatePaid.setEnabled(true);
        tiet_DateDelivered.setEnabled(true);

        //    Changing visibility of components.
        findViewById(R.id.btn_Edit).setVisibility(View.GONE);
//        findViewById(R.id.btn_Cancel).setVisibility(View.VISIBLE);
        findViewById(R.id.btn_Add).setVisibility(View.VISIBLE);
    }
    private void cancel(String saleID) {
        get(saleID);
        isEdit = false;

        tiet_ORSI.setOnClickListener(view -> view(tiet_ORSI));
        tiet_AR.setOnClickListener(view -> view(tiet_AR));

        //    Changing visibility of components.
        findViewById(R.id.btn_Edit).setVisibility(View.VISIBLE);
//        findViewById(R.id.btn_Cancel).setVisibility(View.GONE);
        findViewById(R.id.btn_Create).setVisibility(View.GONE);

        tiet_ORSI.setText("View Image");
        tiet_ORSI.setText("View Image");
    }

    /** <span style="font-size: 50px; font-weight: bold;">DATE</span> */
    CalendarConstraints.DateValidator dateValidator;
    CalendarConstraints.Builder constraintsBuilder;
    MaterialDatePicker.Builder materialDateBuilder;
    MaterialDatePicker materialDatePicker;

    private void datePicker() {
        dateValidator      = DateValidatorPointBackward.now();
        constraintsBuilder = new CalendarConstraints.Builder();
        constraintsBuilder.setValidator(dateValidator);

        materialDateBuilder = MaterialDatePicker.Builder.datePicker();
        materialDateBuilder.setCalendarConstraints(constraintsBuilder.build());
        materialDateBuilder.setTitleText("SELECT DATE");

        materialDatePicker = materialDateBuilder.build();
    }
    private void datePickerDialog(TextInputEditText date) {
        materialDatePicker.show(getSupportFragmentManager(), "MATERIAL_DATE_PICKER");
        materialDatePicker.addOnPositiveButtonClickListener(selection -> date.setText(materialDatePicker.getHeaderText()));
    }

    /** <span style="font-size: 50px; font-weight: bold;">DIALOG</span> */
    Boolean isEdit;

    View layout_ORSI, layout_AR;
    MaterialAlertDialogBuilder builder_ORSI, builder_AR;
    AlertDialog dialog_ORSI, dialog_AR;

    ShapeableImageView iv_ORSI, iv_AR;
    String click;

    Uri uri_ORSI, uri_AR;

    private void dialog() {
        //    Offiicial Receipt / Sales Invoice
        layout_ORSI  = LayoutInflater.from(this).inflate(R.layout.dialog_upload, null, false);
        builder_ORSI = new MaterialAlertDialogBuilder(this)
                .setCancelable(false)
                .setTitle("Offiicial Receipt / Sales Invoice")
                .setView(layout_ORSI)
                .setNegativeButton("Cancel", null)
                .setPositiveButton("Save", null);
        dialog_ORSI = builder_ORSI.create();
        iv_ORSI     = layout_ORSI.findViewById(R.id.iv_Upload);

        //    Acknowledgement Receipt
        layout_AR  = LayoutInflater.from(this).inflate(R.layout.dialog_upload, null, false);
        builder_AR = new MaterialAlertDialogBuilder(this)
                .setCancelable(false)
                .setTitle("Acknowledgement Receipt")
                .setView(layout_AR)
                .setNegativeButton("Cancel", null)
                .setPositiveButton("Save", null);
        dialog_AR = builder_AR.create();
        iv_AR     = layout_AR.findViewById(R.id.iv_Upload);

        dialog_AR.getButton(DialogInterface.BUTTON_NEGATIVE).setOnClickListener(view1 -> {
            dialog_AR.dismiss();
        });
        dialog_AR.getButton(DialogInterface.BUTTON_POSITIVE).setOnClickListener(view1 -> {

        });
    }
    private void upload(TextInputEditText button) {
        click = button.getTag().toString();

        if (click.contains("Official")) {
            dialog_ORSI.show();

            if (isEdit) {
                if (!Objects.isNull(uri_ORSI)) {
                    //    Save image from storage to image view
                    Glide.with(Form_Sales.this)
                            .load(uri_ORSI)
                            .into(iv_ORSI);
                }
            }

            //    Adding listeners to components
            iv_ORSI.setOnClickListener(view -> {
                ImagePicker.Companion.with(Form_Sales.this)
                        .galleryOnly()
                        .cropSquare()
                        .compress(1024) //    Final image size will be less than 1 MB (Optional)
                        .maxResultSize(1080, 1080) //    Final image resolution will be less than
                        //    1080 x 1080 (Optional)
                        .start(1);
            });

            //    Buttons
            dialog_ORSI.getButton(DialogInterface.BUTTON_NEGATIVE).setOnClickListener(view1 -> dialog_ORSI.dismiss());
            dialog_ORSI.getButton(DialogInterface.BUTTON_POSITIVE).setOnClickListener(view1 -> {

            });
        } else {
            dialog_AR.show();

            if (isEdit) {
                if (!Objects.isNull(uri_AR)) {
                    //    Save image from storage to image view
                    Glide.with(Form_Sales.this)
                            .load(uri_AR)
                            .into(iv_AR);
                }
            }

            //    Adding listeners to components
            iv_AR.setOnClickListener(view -> {
                ImagePicker.Companion.with(Form_Sales.this)
                        .galleryOnly()
                        .cropSquare()
                        .compress(1024) //    Final image size will be less than 1 MB (Optional)
                        .maxResultSize(1080, 1080) //    Final image resolution will be less than
                        //    1080 x 1080 (Optional)
                        .start(1);
            });

            //    Buttons
            dialog_AR.getButton(DialogInterface.BUTTON_NEGATIVE).setOnClickListener(view1 -> dialog_AR.dismiss());
            dialog_AR.getButton(DialogInterface.BUTTON_POSITIVE).setOnClickListener(view1 -> {

            });
        }
    }
    private void view(TextInputEditText button) {
        click = button.getTag().toString();

        if (click.contains("Official")) {
            dialog_ORSI.show();

            //    Save image from storage to image view
            Glide.with(Form_Sales.this)
                    .load(uri_ORSI)
                    .into(iv_ORSI);

            //    Buttons
            dialog_ORSI.getButton(DialogInterface.BUTTON_NEGATIVE).setOnClickListener(view1 -> dialog_ORSI.dismiss());
        } else {
            dialog_AR.show();

            //    Save image from storage to image view
            Glide.with(Form_Sales.this)
                    .load(uri_AR)
                    .into(iv_AR);

            //    Buttons
            dialog_AR.getButton(DialogInterface.BUTTON_NEGATIVE).setOnClickListener(view1 -> dialog_AR.dismiss());
        }
    }

    /** <span style="font-size: 50px; font-weight: bold;">OVERRIDE</span> */
    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == 1) {
            uri_ORSI = data.getData();
            iv_ORSI.setImageURI(uri_ORSI);
            iv_ORSI.setTag(uri_ORSI);

            if (Objects.isNull(iv_ORSI.getTag())) {
                iv_ORSI.setImageDrawable(getResources().getDrawable(R.drawable.ic_launcher_background));
                tiet_ORSI.setText("");
            } else {
                tiet_ORSI.setText("View Image");
            }
        } else {
            uri_AR = data.getData();
            iv_AR.setImageURI(uri_AR);
            iv_AR.setTag(uri_AR);

            if (Objects.isNull(iv_AR.getTag())) {
                iv_AR.setImageDrawable(getResources().getDrawable(R.drawable.ic_launcher_background));
                tiet_AR.setText("");
            } else {
                tiet_AR.setText("View Image");
            }
        }
    }
}