package com.pontydysgu.gui;

import android.content.Context;
import android.widget.ArrayAdapter;

import com.pontydysgu.data.QuestionStack;
import com.pontydysgu.data.StackArray;

public class StackArrayAdapter extends ArrayAdapter<QuestionStack> {

	private StackArray stackArray;

	public StackArrayAdapter(StackArray stackArray, Context context, int textViewResourceId) {
		super(context, textViewResourceId);
		this.stackArray = stackArray;
	}

	@Override
	public QuestionStack getItem(int position) {
		return this.stackArray.get(position);
	}
	
	@Override
	public int getCount() {
		return this.stackArray.size();
	}
}
