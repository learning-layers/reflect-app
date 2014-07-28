package com.pontydysgu.webio;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpRequestBase;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

import com.google.gson.Gson;
import com.pontydysgu.data.Answer;
import com.pontydysgu.data.LoginData;
import com.pontydysgu.data.StackArray;

import android.util.Log;

public class PontyService {
	
	
	private static final String WEBSERVICE_BASE_URL = "http://ponty.bluerain.de/index.php?r=";
	
	private final static String GETSTACKS_URL = WEBSERVICE_BASE_URL
			+ "api/stackswithquestions";
	
	private final static String SUBMIT_ANSWER_URL = WEBSERVICE_BASE_URL
			+ "api/answer";
	
	private static final String TAG = "PontyService";
	
	public LoginData logindata;

	public StackArray getUserStacks() throws IOException {
		/*
		BasicClientCookie2 cookie = new BasicClientCookie2("USERNAME",
				"andreas@vratny.de");
		cookie.setAttribute("USERNAME", "andreas@vratny.de");
		cookie.setAttribute("PASSWORD",
				"7c4a8d09ca3762af61e59520943dc26494f8941b");
*/
		//httpclient.getCookieStore().addCookie(cookie);
		
		// Perform GET Request
		HttpGet request = new HttpGet(GETSTACKS_URL);
		String html = this.performRequest(request);
		
		Gson gson = new Gson();
		StackArray result = gson.fromJson(html, StackArray.class);
		Log.i(TAG, "StackArray: "+result);
		return result;
	}
		
	private String performRequest(HttpRequestBase request) throws IOException {
		DefaultHttpClient httpclient = new DefaultHttpClient();

		String username=logindata.getUsername();
		String password=logindata.getPassword();
		
		request.addHeader("Cookie", "USERNAME="+username+";PASSWORD="+password); // TOOD: Could be better
		HttpResponse response = httpclient.execute(request);
		HttpEntity responseEntity = response.getEntity();
		if (responseEntity != null) {
			if (response.getStatusLine().getStatusCode() != 200) {
				String html = EntityUtils.toString(responseEntity);
				Log.i(TAG, "URL "+request.getURI()+"\nHTTP Response: "+html);
				throw new IOException("Unexpected HTTP Status Code: "+response.getStatusLine().getStatusCode());
			}
			
			String html = EntityUtils.toString(responseEntity);
			return html;
			
		} else {
			throw new IOException("Couldn't retrieve webservice content! URL: "+request.getURI());
		}		
	}

	public void sendAnswer(Answer answer) throws IOException {
		if (answer.getQuestionId() == null) throw new IOException("QuestionID is null!");
		Log.i(TAG, "Submitting answer: "+answer);
		HttpPost request = new HttpPost(SUBMIT_ANSWER_URL+"&questionid="+answer.getQuestionId());

		List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
        nameValuePairs.add(new BasicNameValuePair("answer", answer.getAnswerText()));
        request.setEntity(new UrlEncodedFormEntity(nameValuePairs));
		this.performRequest(request);
	}
}
