package com.pontydysgu.data;

import java.math.BigInteger;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class LoginData {

	private String username;
	private String password;

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

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username.toLowerCase().trim();
	}

	public String getPassword() {
		return sha1(password).toLowerCase().trim();
	}

	public void setPassword(String password) {
		this.password = password;
	}

}
