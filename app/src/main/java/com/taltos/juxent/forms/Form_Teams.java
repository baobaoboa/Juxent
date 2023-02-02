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
import com.android.volley.Response;
import com.android.volley.VolleyError;
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
        datePicker();
    }

    /** <span style="font-size: 50px; font-weight: bold;">EMPLOYEE</span> */
    MaterialAutoCompleteTextView actv_CompanyPosition;
    TextInputEditText tiet_FirstName, tiet_LastName, tiet_MiddleName, tiet_Email, tiet_PhoneNumber,
            tiet_Birthdate, tiet_Username, tiet_Password, tiet_ConfirmPassword;

    private void employee() {
        //    Setting up components
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
        findViewById(R.id.btn_Create).setOnClickListener(view -> create());

        tiet_Birthdate.setOnClickListener(view -> datePickerDialog(tiet_Birthdate));
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
//            StringRequest stringRequest = new StringRequest(Request.Method.POST, APIs.REGISTER,
//                    response -> {
//                        Toast.makeText(this, APIs.REGISTER, Toast.LENGTH_SHORT).show();
//                        Log.i("TEST", response);
//
//                        try {
//                            JSONObject jsonObject = new JSONObject(response);
//                            Log.i("MESSAGE", jsonObject.getString("message"));
//                            Toast.makeText(this, "REGISTERED", Toast.LENGTH_SHORT).show();
//                        } catch (JSONException e) {
//                            e.printStackTrace();
//                        }
//                    }, error -> Toast.makeText(this, error.getMessage(), Toast.LENGTH_SHORT).show()) {
//                @Override
//                public Map<String, String> getHeaders() throws AuthFailureError {
//                    Map<String, String> headers = new HashMap<>();
//                    headers.put("Content-Type", "multipart/form-data");
//                    return headers;
//                }
//
//                @Override
//                protected Map<String, String> getParams() throws AuthFailureError {
//                    Map<String, String> params = new HashMap<>();
//                    params.put("first_name", firstName);
//                    params.put("middle_name", lastName);
//                    params.put("last_name", middleName);
//                    params.put("username", username);
//                    params.put("email", email);
//                    params.put("password", password);
//                    params.put("password_confirmation", confirmPassword);
//                    params.put("birthday", birthdate);
//                    params.put("role_id", "1");
//
//                    return params;
//                }
//            };
////            stringRequest.setRetryPolicy(new DefaultRetryPolicy(50000, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
////            stringRequest.setShouldCache(false);
//
//            RequestHandler.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);

            StringRequest stringRequest= new StringRequest(Request.Method.POST, APIs.REGISTER, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {

                    try {
                        Log.i("RESPONSE", "["+response+"]");
                        JSONObject jsonObject = new JSONObject(response);
                        Toast.makeText(getApplicationContext(), "WORKS" , Toast.LENGTH_SHORT).show();
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(getApplicationContext(), error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }){
                @Override
                public Map<String, String> getHeaders() throws AuthFailureError {
                    Map<String, String> headers = new HashMap<>();
                    headers.put("Content-Type", "multipart/form-data");
                    return headers;
                }

                @Nullable
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

            RequestHandler.getInstance(getApplicationContext()).addToRequestQueue(stringRequest);
        }
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
}