package com.taltos.juxent.forms;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextUtils;
import android.text.TextWatcher;
import android.util.Log;
import android.widget.ImageView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.toolbox.StringRequest;
import com.github.dhaval2404.imagepicker.ImagePicker;
import com.google.android.material.datepicker.CalendarConstraints;
import com.google.android.material.datepicker.DateValidatorPointBackward;
import com.google.android.material.datepicker.MaterialDatePicker;
import com.google.android.material.textfield.MaterialAutoCompleteTextView;
import com.google.android.material.textfield.TextInputEditText;
import com.taltos.juxent.R;
import com.taltos.juxent.extensions.APIs;
import com.taltos.juxent.extensions.RequestHandler;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;
import java.util.Objects;

public class Form_Teams extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.form_teams);

        employee();
    }

    /** <span style="font-size: 50px; font-weight: bold;">EMPLOYEE</span> */
    ImageView iv_DisplayImage;
    MaterialAutoCompleteTextView actv_CompanyPosition;
    TextInputEditText tiet_FirstName, tiet_LastName, tiet_MiddleName, tiet_Email, tiet_PhoneNumber,
            tiet_Birthdate, tiet_Username, tiet_Password, tiet_ConfirmPassword;

    Uri uri_DisplayImage;

    private void employee() {
        //    Setting up components
        iv_DisplayImage      = findViewById(R.id.iv_DisplayImage);
        actv_CompanyPosition = findViewById(R.id.actv_CompanyPosition);

        tiet_FirstName       = findViewById(R.id.tiet_FirstName);
        tiet_LastName        = findViewById(R.id.tiet_LastName);
        tiet_MiddleName      = findViewById(R.id.tiet_MiddleName);
        tiet_Email           = findViewById(R.id.tiet_Email);
        tiet_PhoneNumber     = findViewById(R.id.tiet_PhoneNumber);
        tiet_Birthdate       = findViewById(R.id.tiet_Birthdate);
        tiet_Username        = findViewById(R.id.tiet_Username);
        tiet_Password        = findViewById(R.id.tiet_Password);
        tiet_ConfirmPassword = findViewById(R.id.tiet_ConfirmPassword);

        //    Setting up values



        //    Adding listeners to components
        findViewById(R.id.btn_Exit).setOnClickListener(view -> onBackPressed());
        findViewById(R.id.tiet_Birthdate).setOnClickListener(view -> datePicker(tiet_Birthdate));
        findViewById(R.id.btn_Create).setOnClickListener(view -> create());

        iv_DisplayImage.setOnClickListener(view -> UploadImage());
    }
    private void create() {
        //    Save inputs
        final String companyPosition = actv_CompanyPosition.getText().toString();
        final String firstName       = tiet_FirstName.getText().toString();
        final String lastName        = tiet_LastName.getText().toString();
        final String middleName      = tiet_MiddleName.getText().toString();
        final String email           = tiet_Email.getText().toString();
        final String phoneNumber     = tiet_PhoneNumber.getText().toString();
        final String birthdate       = tiet_Birthdate.getText().toString();
        final String username        = tiet_Username.getText().toString();
        final String password        = tiet_Password.getText().toString();
        final String confirmPassword = tiet_ConfirmPassword.getText().toString();

        //    Validate inputs
        {
//            if (Objects.isNull(iv_DisplayImage.getTag())) {
//                Toast.makeText(this, "Please insert a profile picture", Toast.LENGTH_SHORT).show();
//                cv_Team.setStrokeWidth(2);
//                cv_Team.requestFocus();
//
//                return;
//            }
//            if (TextUtils.isEmpty(companyPosition)) {
//                actv_CompanyPosition.setError("Please choose a company position");
//                actv_CompanyPosition.requestFocus();
//
//                return;
//            }
            if (TextUtils.isEmpty(firstName)) {
                tiet_FirstName.setError("Please enter a first name");
                tiet_FirstName.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(lastName)) {
                tiet_LastName.setError("Please enter a last name");
                tiet_LastName.requestFocus();

                return;
            }
            if (!android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
                tiet_Email.setError("Please enter an email address");
                tiet_Email.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(phoneNumber)) {
                tiet_PhoneNumber.setError("Please enter a phone number");
                tiet_PhoneNumber.requestFocus();

                return;
            }
            if (phoneNumber.length() < 10) {
                tiet_PhoneNumber.setError("Phone number should be 10 digits (+63 excluded)");
                tiet_PhoneNumber.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(birthdate)) {
                tiet_Birthdate.setError("Please enter a birthday");
                tiet_Birthdate.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(username)) {
                tiet_Username.setError("Please enter a username");
                tiet_Username.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(password)) {
                tiet_Password.setError("Please enter a password");
                tiet_Password.requestFocus();

                return;
            }
            if (password.length() < 6) {
                tiet_Password.setError("Password should be at least 6 characters");
                tiet_Password.requestFocus();

                return;
            }
            if (TextUtils.isEmpty(confirmPassword)) {
                tiet_ConfirmPassword.setError("Please enter a confirm password");
                tiet_ConfirmPassword.requestFocus();

                return;
            }
            if (!confirmPassword.equals(password)) {
                tiet_ConfirmPassword.setError("Password doesn't match");
                tiet_ConfirmPassword.requestFocus();

                return;
            }
        }

        //    Module
        {
            StringRequest stringRequest = new StringRequest(Request.Method.POST, APIs.REGISTER,
                    response -> {
                        Toast.makeText(this, APIs.REGISTER, Toast.LENGTH_SHORT).show();
                        Log.i("TEST", response);

                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            Toast.makeText(this, "REGISTERED", Toast.LENGTH_SHORT).show();
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }, error -> Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_SHORT).show()) {
                @Override
                public Map<String, String> getHeaders() throws AuthFailureError {
                    Map<String, String> headers = new HashMap<>();
                    headers.put("Content-Type", "multipart/form-data");
                    return headers;
                }

                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> params = new HashMap<>();
                    params.put("first_name", firstName);
                    params.put("middle_name", lastName);
                    params.put("last_name", middleName);
                    params.put("username", username);
                    params.put("email", email);
                    params.put("password", password);
                    params.put("password_confirmation", confirmPassword);
                    params.put("birthday", birthdate);
                    params.put("role_id", "1");

                    return params;
                }
            };
            stringRequest.setRetryPolicy(new DefaultRetryPolicy(50000, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
            stringRequest.setShouldCache(false);

            RequestHandler.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
        }
    }

    /** <span style="font-size: 50px; font-weight: bold;">DATE</span> */
    private void datePicker(TextInputEditText date) {
        CalendarConstraints.DateValidator dateValidator = DateValidatorPointBackward.now();
        CalendarConstraints.Builder constraintsBuilder  = new CalendarConstraints.Builder();
        constraintsBuilder.setValidator(dateValidator);

        MaterialDatePicker.Builder materialDateBuilder = MaterialDatePicker.Builder.datePicker();
        materialDateBuilder.setCalendarConstraints(constraintsBuilder.build());
        materialDateBuilder.setTitleText("SELECT YOUR BIRTHDATE");

        final MaterialDatePicker materialDatePicker = materialDateBuilder.build();
        materialDatePicker.show(getSupportFragmentManager(), "MATERIAL_DATE_PICKER");
        materialDatePicker.addOnPositiveButtonClickListener(selection -> date.setText(materialDatePicker.getHeaderText()));
    }

    /** <span style="font-size: 50px; font-weight: bold;">IMAGE</span> */
    public void UploadImage() {
        iv_DisplayImage.setOnClickListener(view -> {
            ImagePicker.Companion.with(this)
                    .galleryOnly()
                    .cropSquare()
                    .compress(1024) // Final image size will be less than 1 MB (Optional)
                    .maxResultSize(1080, 1080) // Final image resolution will be less than
                    // 1080 x 1080 (Optional)
                    .start(1);
        });
    }

    /** <span style="font-size: 50px; font-weight: bold;">OVERRIDE</span> */
    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode == 1) {
            uri_DisplayImage = data.getData();
            iv_DisplayImage.setImageURI(uri_DisplayImage);
            iv_DisplayImage.setTag(uri_DisplayImage);

            if (Objects.isNull(iv_DisplayImage.getTag())) {
                iv_DisplayImage.setImageDrawable(getResources().getDrawable(R.drawable.ic_launcher_background));
            }
        }
    }
}