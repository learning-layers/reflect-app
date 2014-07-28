package com.pontydysgu.webio;

import com.pontydysgu.data.Answer;
import com.pontydysgu.data.LoginData;

import android.os.AsyncTask;
import android.util.Log;

public class SubmitAnswerTask extends AsyncTask<String, Void, Void> {
	private Exception exception;
	private SubmitAnswerCallback callback;
	private Answer answer;
	private LoginData logindata;

	public SubmitAnswerTask(SubmitAnswerCallback callback, Answer answer, LoginData loginData) {
		this.callback = callback;
		this.answer = answer;
		this.logindata= loginData;
	}

	protected Void doInBackground(String... urls) {
		try {
			PontyService service = new PontyService();
			service.logindata=this.logindata;
			service.sendAnswer(answer);
			return null;
		} catch (Exception e) {
			Log.e("RetrieveStacksTask", "Error", e);
			this.exception = e;
			return null;
		}
	}

	protected void onPostExecute(Void d) {
		if (this.exception == null) {
			this.callback.onAnswerCommited(this.answer);
		} else {
			this.callback.onAnswerCommitFailed(this.answer);
		}
	}
}
