package com.pontydysgu.webio;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.math.BigInteger;
import java.net.URLEncoder;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.concurrent.ExecutionException;

import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.StatusLine;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;

import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

public class LoginService {

	private static final String BASE_URL = "http://ponty.bluerain.de/index.php";

	private static final String VALID_LOGIN = "?r=api/isAuthValid";

	// see http://androidsnippets.com/sha-1-hash-function
	public String sha1(String s) {
		MessageDigest digest = null;
		try {
			digest = MessageDigest.getInstance("SHA-1");
		} catch (NoSuchAlgorithmException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		digest.reset();
		byte[] data = digest.digest(s.getBytes());
		return String.format("%0" + (data.length * 2) + "X", new BigInteger(1,
				data));
	}

	public boolean isLoginValid(String Username, String Password)
			throws IOException, InterruptedException, ExecutionException {

		String URL = BASE_URL
				+ VALID_LOGIN + "&USERNAME=" + Username
						+ "&PASSWORD=" + sha1(Password);
		Log.i("Loginservice", URL);
		

		GetWebRequest gwr = new GetWebRequest();
		String result = gwr.execute(URL).get();
		if(result==null)
		{
			result=" ";
		}
		Log.i("Loginservice", "THIS IS: " + result);
		
		if (result.contains("ok"))
		{
			return true;
			
		}else
		{
			return false;
		}

	}

}
