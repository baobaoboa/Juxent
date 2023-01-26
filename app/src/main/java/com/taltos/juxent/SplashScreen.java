package com.taltos.juxent;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;

public class SplashScreen extends AppCompatActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.splashscreen);

		//    Adding delay to splash screen before moving to its intent
		new Handler().postDelayed(() -> {
			Intent intent = new Intent(SplashScreen.this, Login.class);
			startActivity(intent);
			finish();
		}, 1500);
	}
}