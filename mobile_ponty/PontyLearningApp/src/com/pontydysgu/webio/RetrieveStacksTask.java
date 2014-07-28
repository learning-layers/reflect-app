package com.pontydysgu.webio;

import android.os.AsyncTask;
import android.util.Log;

import com.pontydysgu.data.LoginData;
import com.pontydysgu.data.StackArray;

public class RetrieveStacksTask extends AsyncTask<String, Void, StackArray> {
	private Exception exception;
	private RetrieveStacksCallback callback;
	
	private LoginData logindata;

	public RetrieveStacksTask(RetrieveStacksCallback callback, LoginData logindata) {
		this.callback = callback;
		this.logindata = logindata;
	}

	protected StackArray doInBackground(String... urls) {
		try {
			PontyService service = new PontyService();
			service.logindata=this.logindata;
			return service.getUserStacks();
		} catch (Exception e) {
			Log.e("RetrieveStacksTask", "Error", e);
			this.exception = e;
			return null;
		}
	}

	protected void onPostExecute(StackArray stackArray) {
		this.callback.onStacksRecieved(stackArray);
	}
}
