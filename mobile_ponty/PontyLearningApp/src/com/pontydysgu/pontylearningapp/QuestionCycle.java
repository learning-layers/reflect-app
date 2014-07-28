package com.pontydysgu.pontylearningapp;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

import com.example.pontylearningapp.R;
import com.pontydysgu.data.Answer;
import com.pontydysgu.data.LoginData;
import com.pontydysgu.data.Question;
import com.pontydysgu.data.QuestionStack;
import com.pontydysgu.webio.SubmitAnswerCallback;
import com.pontydysgu.webio.SubmitAnswerTask;

import android.os.Bundle;
import android.app.Activity;
import android.content.ActivityNotFoundException;
import android.content.Intent;
import android.content.SharedPreferences;
import android.speech.RecognizerIntent;
import android.speech.tts.TextToSpeech;
import android.speech.tts.TextToSpeech.OnInitListener;
import android.speech.tts.TextToSpeech.OnUtteranceCompletedListener;
import android.speech.tts.UtteranceProgressListener;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

public class QuestionCycle extends Activity implements OnInitListener,
		SubmitAnswerCallback {

	public static final String PREFS_NAME = "PontydysguLearningApp";
	public static final String PREF_TMPUSERNAME = "TMPPontyUser";
	public static final String PREF_TMPPASSWORD = "TMPPontyPass";

	protected static final int RESULT_SPEECH = 1;

	private static final int MY_DATA_CHECK_CODE = 12323120;

	protected static final String TAG = "MainActivity";

	private ImageButton btnSpeak;
	private Button btnGO;
	private TextView txtText;

	private TextToSpeech mTts;

	private TextView textViewQuestion;

	private QuestionStack questionStack;

	private int questionIndex;

	private LoginData logindata;

	private String lasttext;
	public String lastcommand = "";

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_question_cycle);

		// Restore preferences
		SharedPreferences settings = getSharedPreferences(PREFS_NAME, 0);
		String username = settings.getString(PREF_TMPUSERNAME, "");
		String password = settings.getString(PREF_TMPPASSWORD, "");

		logindata = new LoginData();
		logindata.setPassword(password);
		logindata.setUsername(username);

		this.txtText = (TextView) findViewById(R.id.txtText);

		this.txtText.setText("");

		long stackId = this.getIntent().getLongExtra("stackId", -1);
		// DEBUG: txtText.setText("Stack ID "+stackId);

		this.questionStack = DataService.getInstance()
				.getQuestionStack(stackId);
		if (this.questionStack == null) {
			Toast.makeText(this, "Questionstack not found!", Toast.LENGTH_LONG)
					.show();
		}
		


		this.questionIndex = 0;

		this.btnGO = (Button) findViewById(R.id.buttonGO);

		this.textViewQuestion = (TextView) findViewById(R.id.textViewQuestion);

		this.overtakeQuestion(0);

		this.btnGO.setOnClickListener(new View.OnClickListener() {

			@Override
			public void onClick(View v) {
				speakCurrentQuestion();
			}
		});

		Intent checkIntent = new Intent();
		checkIntent.setAction(TextToSpeech.Engine.ACTION_CHECK_TTS_DATA);
		startActivityForResult(checkIntent, MY_DATA_CHECK_CODE);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.question_cycle, menu);
		return true;
	}

	protected void speakCurrentQuestion() {
		this.speak("" + QuestionCycle.this.textViewQuestion.getText(),
				"Question" + System.currentTimeMillis());
	}

	private void overtakeQuestion(int moveBy) {
		this.questionIndex += moveBy;
		if (this.questionIndex >= this.questionStack.getQuestions().size()) {
			this.questionIndex = this.questionStack.getQuestions().size() - 1;
		} else if (this.questionIndex < 0) {
			this.questionIndex = 0;
		}
		Question question = this.getCurrentQuestion();

		this.textViewQuestion.setText(question.getName());
	}

	protected void startSpeechRecognition() {
		Intent intent = new Intent(RecognizerIntent.ACTION_RECOGNIZE_SPEECH); // ACTION_VOICE_SEARCH_HANDS_FREE

		intent.putExtra(RecognizerIntent.EXTRA_LANGUAGE_MODEL, "en-US");
		// intent.putExtra(RecognizerIntent.ACTION_VOICE_SEARCH_HANDS_FREE,
		// true);
		intent.putExtra(
				RecognizerIntent.EXTRA_SPEECH_INPUT_MINIMUM_LENGTH_MILLIS,
				10000);
		try {
			startActivityForResult(intent, RESULT_SPEECH);
		} catch (ActivityNotFoundException a) {
			Toast t = Toast.makeText(getApplicationContext(),
					"Opps! Your device doesn't support Speech to Text",
					Toast.LENGTH_SHORT);
			t.show();
		}
	}

	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);

		switch (requestCode) {
		case RESULT_SPEECH: {
			if (resultCode == RESULT_OK && null != data) {

				ArrayList<String> text = data
						.getStringArrayListExtra(RecognizerIntent.EXTRA_RESULTS);

				onSpokenTextResult(text.get(0));
			}
			break;
		}
		case MY_DATA_CHECK_CODE:
			if (resultCode == TextToSpeech.Engine.CHECK_VOICE_DATA_PASS) {
				/*
				 * Toast t = Toast.makeText(this, "Text to Speech verfügbar!",
				 * Toast.LENGTH_LONG); t.show();
				 */
				// success, create the TTS instance
				mTts = new TextToSpeech(this, this);

				final ScheduledExecutorService exec = Executors
						.newScheduledThreadPool(1);

				exec.schedule(new Runnable() {
					@Override
					public void run() {
						speakCurrentQuestion();
					}
				}, 1, TimeUnit.SECONDS);
			} else {
				// missing data, install it
				Intent installIntent = new Intent();
				installIntent
						.setAction(TextToSpeech.Engine.ACTION_INSTALL_TTS_DATA);
				startActivity(installIntent);
			}
			break;
		default:
			Log.i(TAG, "Other activity result: " + requestCode);
			break;
		}
	}

	private void speak(String text, String utteranceID) {
		if (this.mTts == null) {
			Toast t = Toast.makeText(getApplicationContext(),
					"Text to speech is still loading!", Toast.LENGTH_SHORT);
			t.show();
			return;
		}
		HashMap<String, String> options = new HashMap<String, String>();
		if (utteranceID != null) {
			options.put(TextToSpeech.Engine.KEY_PARAM_UTTERANCE_ID, utteranceID);
		}
		this.mTts.speak(text, TextToSpeech.QUEUE_ADD, options);
	}

	private void onSpokenTextResult(String text) {
		Log.i(TAG, "onSpokenTextResult: " + text);
		String newText;

		if ((txtText.getText() + "").trim().length() > 0) {
			newText = txtText.getText() + ". " + text;
		} else {
			newText = text;
			// lasttext="";
		}
		boolean gotoNext = false;
		boolean startSpeechRecognition = true;
		boolean command = false;

		if (newText.toLowerCase().contains("kevin next question")) {
			newText = newText.replace("kevin next question", "");

			if (this.txtText.getText().toString().trim() != "") {
				// Submit text
				Answer answer = new Answer();
				answer.setQuestionId(this.getCurrentQuestion().getId());
				answer.setAnswerText(this.txtText.getText() + "");
				new SubmitAnswerTask(this, answer, this.logindata).execute();
			}

			gotoNext = true;
			newText = "";
			command = true;
			this.lastcommand = "kevin next question";
		}

		if (newText.toLowerCase().contains("kevin repeat question")) {
			newText = newText.replace("kevin repeat question", "");

			this.speakCurrentQuestion();
			startSpeechRecognition = false;
			command = true;
			this.lastcommand = "repeat question";
		}

		if (newText.toLowerCase().contains("kevin help me")) {
			newText = newText.replace("kevin help me", "");

			String stext = "say kevin next question for moving on to next question.";
			stext += "....... say kevin repeat question for repeating the question.";
			stext += "....... say kevin other options for other options";

			startSpeechRecognition = false;
			speak(stext, "HELPME");
			command = true;
			this.lastcommand = "help me";
		}

		if (newText.toLowerCase().contains("kevin other options")) {
			newText = newText.replace("kevin other options", "");

			String stext = "say kevin repeat answer, if you want to repeat the answer.";
			stext += "....... say kevin delete answer, if you want to delete answer.";
			stext += "....... say kevin delete last one, if you want to delete the last record.";
			startSpeechRecognition = false;
			speak(stext, "HELPME");
			command = true;
			this.lastcommand = "other options";
		}

		if (newText.toLowerCase().contains("kevin repeat answer")) {
			newText = newText.replace("kevin repeat answer", "");

			startSpeechRecognition = false;
			speak(newText, "WHATDIDYOUUNDERSTAND");
			command = true;
			this.lastcommand = "repeat answer";
		}

		if (newText.toLowerCase().contains("kevin delete last one")
				|| newText.toLowerCase().contains("kevin delete last 1")) {
			newText = newText.replace("kevin delete last one", "");
			newText = newText.replace("kevin delete last 1", "");

			newText = newText.replace(this.lasttext, "");

			startSpeechRecognition = false;
			speak("I deleted the last words!", "DELETETHELASTONE");
			command = true;
			this.lastcommand = "kevin delete last one";
		}

		if (newText.toLowerCase().contains("kevin delete answer")) {
			newText = newText.replace("kevin delete answer", "");
			if (newText.trim() == "") {
				speak("No answer to delete!", "NOANSWER");
			} else {
				newText = "";
				speak("Answer deleted!", "ANSWERDELETED");
				startSpeechRecognition = false;
				this.speakCurrentQuestion();
			}

			command = true;
			this.lastcommand = "kevin delete answer";
		}

		if (!command) {
			this.lasttext = text;
		}

		txtText.setText(newText);

		if (gotoNext) {
			// Submit Answer TODO: Queue e.g. in textfile
			if (isLastQuestion()) {
				this.speak("Thank you for this nice interview",
						"INTERVIEWFINISHED");
				// this.finish();
				startSpeechRecognition = false;
			} else {
				// Goto next next question
				this.overtakeQuestion(+1);
				startSpeechRecognition = false;
				this.speakCurrentQuestion();
			}
		}
		if (startSpeechRecognition) {
			startSpeechRecognition();
		}

		// this.speak("Transmitting data. Please wait");
	}

	private boolean isLastQuestion() {
		return (this.questionStack.getQuestions().size() - 1 == this.questionIndex);
	}

	private Question getCurrentQuestion() {
			return this.questionStack.getQuestions().get(this.questionIndex);
	}

	@Override
	public void onInit(int arg0) {
		mTts.setOnUtteranceProgressListener(new UtteranceProgressListener() {

			@Override
			public void onStart(String utteranceId) {
				Log.i(TAG, "onStart " + utteranceId);
			}

			@Override
			public void onError(String utteranceId) {
				Log.i(TAG, "onError " + utteranceId);
			}

			@Override
			public void onDone(String utteranceId) {
				Log.i(TAG, "onDone" + utteranceId);
				if (utteranceId.contains("INTERVIEWFINISHED")) {
					QuestionCycle.this.endActivity();
					return;
				}
				runOnUiThread(new Runnable() {
					@Override
					public void run() {
						/*
						 * Toast t = Toast.makeText(MainActivity.this,
						 * "Ready to start interview", Toast.LENGTH_LONG);
						 * t.show();
						 */
						QuestionCycle.this.startSpeechRecognition();
					}

				});

			}
		});
	}

	@Override
	public void onAnswerCommited(Answer answer) {
		String msg = "Answer has been commited";
		Log.i(TAG, msg);
		// Toast.makeText(this, msg, Toast.LENGTH_SHORT).show();
		// this.speak(msg, null);
	}

	@Override
	public void onAnswerCommitFailed(Answer answer) {
		// TODO: Queue answers in e.g. a text file
		this.speak("Answer commit failed!", null);
	}

	public void endActivity() {
		this.finish();
	}

}
