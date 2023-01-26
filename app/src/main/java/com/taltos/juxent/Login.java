package com.taltos.juxent;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

public class Login extends AppCompatActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.login);

		findViewById(R.id.btn_Login).setOnClickListener(view -> startActivity(new Intent(this, Juxent.class)));
	}
}