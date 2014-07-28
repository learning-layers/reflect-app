package com.pontydysgu.pontylearningapp;

import com.example.pontylearningapp.R;
import com.pontydysgu.data.LoginData;
import com.pontydysgu.data.QuestionStack;
import com.pontydysgu.data.StackArray;
import com.pontydysgu.gui.StackArrayAdapter;
import com.pontydysgu.webio.RetrieveStacksTask;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.Toast;

import com.pontydysgu.webio.*;

public class Stackoverview extends Activity implements RetrieveStacksCallback {
	
	public static final String PREFS_NAME = "PontydysguLearningApp";
	public static final String PREF_TMPUSERNAME = "TMPPontyUser";
	public static final String PREF_TMPPASSWORD = "TMPPontyPass";
	
	private LoginData logindata;

	private ListView listView;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_stackoverview);
		
		// Restore preferences
		SharedPreferences settings = getSharedPreferences(PREFS_NAME, 0);
		String username = settings.getString(PREF_TMPUSERNAME, "");
		String password = settings.getString(PREF_TMPPASSWORD, "");

		logindata = new LoginData();
		logindata.setPassword(password);
		logindata.setUsername(username);
		
		//this.setTitle("Ponty Learning App");
		this.listView = (ListView) this.findViewById(R.id.listView);
		
		this.listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> adapterView, View view, int position,
					long id) {
				StackArrayAdapter adapter = (StackArrayAdapter) adapterView.getAdapter();
				QuestionStack item = adapter.getItem(position);
				if (item.getQuestions() != null && item.getQuestions().size() > 0) {
					onStackClicked(item);
				} else {
					Toast.makeText(Stackoverview.this, "There are no questions in the stack!", Toast.LENGTH_LONG).show();
				}
				
			}
		});
		
		// Start retrieve stacks task in background
		RetrieveStacksTask getStacks = new RetrieveStacksTask(this, this.logindata);
		getStacks.execute();
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.stackoverview, menu);
		return true;
	}
	
	protected void onStackClicked(QuestionStack item) {
			
		Intent intent = new Intent(this, QuestionCycle.class);
	    intent.putExtra("stackId", item.getId());
	    startActivity(intent);
	}
	
	@Override
	public void onStacksRecieved(StackArray stackArray) {
		DataService.getInstance().setStackArray(stackArray);
		
		// this.listView.set
		//Log.i(TAG, "Recieved Stacklist: "+stackArray);
		StackArrayAdapter listAdapter = new StackArrayAdapter(stackArray, this, android.R.layout.simple_list_item_1);
		this.listView.setAdapter(listAdapter);
	}

}
