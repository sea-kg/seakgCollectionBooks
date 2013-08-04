package com.seakg.whc;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.widget.TextView;

public class CollectionActivity extends Activity {

	private String strName;
	private String strUrl;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_collection);
		
		Intent intent = getIntent();
		strName = intent.getStringExtra("name");
		strUrl = intent.getStringExtra("url");
		
		TextView tvName = (TextView)findViewById(R.id.tvCollectionActivityName);
		TextView tvUrl = (TextView)findViewById(R.id.tvCollectionActivityUrl);
		tvName.setText(strName);
		tvUrl.setText(strUrl);
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.collection, menu);
		return true;
	}

}
