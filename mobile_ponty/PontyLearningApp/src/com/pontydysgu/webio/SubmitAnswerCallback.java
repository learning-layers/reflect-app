package com.pontydysgu.webio;

import com.pontydysgu.data.Answer;


public interface SubmitAnswerCallback {

	void onAnswerCommited(Answer answer);

	void onAnswerCommitFailed(Answer answer);

}
