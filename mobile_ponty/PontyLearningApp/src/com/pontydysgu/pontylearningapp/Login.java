package com.pontydysgu.pontylearningapp;

import java.io.IOException;
import java.util.concurrent.ExecutionException;

import com.example.pontylearningapp.R;
import com.pontydysgu.webio.LoginService;

import android.net.Uri;
import android.os.Bundle;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.view.Menu;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

public class Login extends Activity {

	Button registernowbutton;
	Button loginbutton;
	EditText emailtext;
	EditText passwordtext;
	CheckBox rememberme;

	public static final String PREFS_NAME = "PontydysguLearningApp";
	public static final String PREF_USERNAME = "PontyUser";
	public static final String PREF_PASSWORD = "PontyPass";

	public static final String PREF_TMPUSERNAME = "TMPPontyUser";
	public static final String PREF_TMPPASSWORD = "TMPPontyPass";

	public static final String PREF_REMEMBER = "PontyRem";

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);

		emailtext = (EditText) findViewById(R.id.emailtext);
		passwordtext = (EditText) findViewById(R.id.passwordtext);
		rememberme = (CheckBox) findViewById(R.id.checkBoxremember);

		// Restore preferences
		SharedPreferences settings = getSharedPreferences(PREFS_NAME, 0);
		boolean autologin = settings.getBoolean(PREF_REMEMBER, false);
		String username = settings.getString(PREF_USERNAME, "");
		String password = settings.getString(PREF_PASSWORD, "");

		if (autologin) {
			emailtext.setText(username);
			passwordtext.setText(password);
			rememberme.setChecked(true);
		}

		addListenerOnRegisterNowButton();

		addListenerOnLoginButton();
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.login, menu);
		return true;
	}

	public void openWebURL(String inURL) {
		Intent browse = new Intent(Intent.ACTION_VIEW, Uri.parse(inURL));

		startActivity(browse);
	}

	public void addListenerOnRegisterNowButton() {

		registernowbutton = (Button) findViewById(R.id.registernow);

		registernowbutton.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {

				Intent browserIntent = new Intent(
						Intent.ACTION_VIEW,
						Uri.parse("http://ponty.bluerain.de/index.php?r=user/register"));
				startActivity(browserIntent);

			}

		});

	}

	public void addListenerOnLoginButton() {

		loginbutton = (Button) findViewById(R.id.loginbutton);

		loginbutton.setOnClickListener(new OnClickListener() {

			@Override
			public void onClick(View arg0) {

				CharSequence text = "Response failure!";

				LoginService loginservice = new LoginService();

				try {
					if (emailtext.getText().toString().trim().isEmpty()
							|| passwordtext.getText().toString().trim()
									.isEmpty()) {
						text = "Login is not valid!";

					} else if (loginservice.isLoginValid(emailtext.getText()
							.toString(), passwordtext.getText().toString())) {
						text = "Welcome! Your login data was correct.";

						if (rememberme.isChecked()) {
							getSharedPreferences(PREFS_NAME, MODE_PRIVATE)
									.edit()
									.putString(PREF_USERNAME,
											emailtext.getText().toString())
									.putString(PREF_PASSWORD,
											passwordtext.getText().toString())
									.putBoolean(PREF_REMEMBER,
											rememberme.isChecked()).commit();
						} else {
							getSharedPreferences(PREFS_NAME, MODE_PRIVATE)
									.edit()
									.putString(PREF_USERNAME, "")
									.putString(PREF_PASSWORD, "")
									.putBoolean(PREF_REMEMBER,
											rememberme.isChecked()).commit();
						}

						getSharedPreferences(PREFS_NAME, MODE_PRIVATE)
								.edit()
								.putString(PREF_TMPUSERNAME,
										emailtext.getText().toString())
								.putString(PREF_TMPPASSWORD,
										passwordtext.getText().toString())
								.commit();

						Intent stackoverview = new Intent(arg0.getContext(),
								Stackoverview.class);
						startActivity(stackoverview);
					} else {
						text = "Login is not valid!";
					}
				} catch (IOException e) {
					text = "Login is not valid!";
					e.printStackTrace();
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				} catch (ExecutionException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				Context context = getApplicationContext();

				int duration = Toast.LENGTH_SHORT;

				Toast toast = Toast.makeText(context, text, duration);
				toast.show();

			}

		});

	}
}
