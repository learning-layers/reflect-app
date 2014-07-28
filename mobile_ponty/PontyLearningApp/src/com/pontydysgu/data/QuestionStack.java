package com.pontydysgu.data;

import java.util.ArrayList;
import java.util.Date;

public class QuestionStack {
	private String name;
	private String description;
	private Long id;
	private ArrayList<Question> questions;
	
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public String getDescription() {
		return description;
	}
	public void setDescription(String description) {
		this.description = description;
	}
	public Long getId() {
		return id;
	}
	public void setId(Long id) {
		this.id = id;
	}
	
	public ArrayList<Question> getQuestions() {
		return questions;
	}
	public void setQuestions(ArrayList<Question> questions) {
		this.questions = questions;
	}
	
	@Override
	public String toString() {
		return this.getName(); //  this.getClass().getSimpleName()+"["+this.name+" ("+this.id+") Questions: "+this.questions.size()+"]";
	}
}
/**
[
    {
        "id": "13",
        "name": "My business day",
        "description": "All about my business",
        "user_id": "1",
        "created": "2013-05-08 18:42:37",
        "questions": [
            {
                "id": "9",
                "public": "0",
                "name": "What time did I go to work?",
                "blocked": "1",
                "stack_id": "13",
                "category_id": null,
                "rating": "0",
                "created": "2013-05-13 11:06:43"
            },
            {
                "id": "10",
                "public": "0",
                "name": "How many people are sick?",
                "blocked": "1",
                "stack_id": "13",
                "category_id": "1",
                "rating": "0",
                "created": "2013-05-13 11:07:30"
            },
            {
                "id": "11",
                "public": "1",
                "name": "What was important?",
                "blocked": "1",
                "stack_id": "13",
                "category_id": "1",
                "rating": "0",
                "created": "2013-05-13 11:08:06"
            }
        ]
    },
    {
        "id": "14",
        "name": "My private things",
        "description": "",
        "user_id": "1",
        "created": "2013-05-13 11:11:12",
        "questions": [
            {
                "id": "12",
                "public": "1",
                "name": "How was the weather?",
                "blocked": "1",
                "stack_id": "14",
                "category_id": null,
                "rating": "0",
                "created": "2013-05-13 11:11:44"
            }
        ]
    }
]
*/