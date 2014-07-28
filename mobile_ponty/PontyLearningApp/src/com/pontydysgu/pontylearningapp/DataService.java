package com.pontydysgu.pontylearningapp;

import com.pontydysgu.data.QuestionStack;
import com.pontydysgu.data.StackArray;

public class DataService {
	private static DataService singleton;
	public static final DataService getInstance() {
		if (singleton == null) {
			singleton = new DataService();
		}
		return singleton;
	}
	
	private StackArray stackArray;
	
	public StackArray getStackArray() {
		return this.stackArray;
	}

	public void setStackArray(StackArray stackArray) {
		this.stackArray = stackArray;
	}
	
	public QuestionStack getQuestionStack(Long id) {
		if (this.stackArray == null) return null;
		for (QuestionStack stack : this.stackArray) {
			if (id.equals(stack.getId())) {
				return stack;
			}
		}
		return null;
	}
}
