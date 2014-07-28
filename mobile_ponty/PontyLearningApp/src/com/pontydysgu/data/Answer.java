package com.pontydysgu.data;

public class Answer {
	private Long questionId;
	private String answerText;
	
	public Long getQuestionId() {
		return questionId;
	}
	public void setQuestionId(Long questionId) {
		this.questionId = questionId;
	}
	public String getAnswerText() {
		return answerText;
	}
	public void setAnswerText(String answerText) {
		this.answerText = answerText;
	}
	
	@Override
	public String toString() {
		return "Answer["+this.getAnswerText()+"]";
	}
}
