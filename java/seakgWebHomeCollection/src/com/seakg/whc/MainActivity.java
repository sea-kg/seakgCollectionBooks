package com.seakg.whc;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

import org.apache.commons.io.FileUtils;
import org.json.JSONException;
import org.json.JSONObject;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;
// import android.widget.ArrayAdapter;
// import android.widget.ListView;

public class MainActivity extends Activity {

	private List<collectionItemView> itemViews = new ArrayList<collectionItemView>(); 
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		
		Toast.makeText(MainActivity.this, "Hello!", Toast.LENGTH_LONG).show();
		
		ProgressBar prgDownloading = (ProgressBar)findViewById(R.id.prgDownloading);
		prgDownloading.setVisibility(View.INVISIBLE);
		
		setupBtnOk();
		registerClickListView();
	}

	private String filterDirname(String url)
	{
		String temp = "";
		for(int i=0; i < url.length(); i++)
		{
			char ch = url.charAt(i);
			if(  
				Character.isJavaLetterOrDigit(ch) 
				|| ch == '-'
				|| ch == '.'
			)
				temp += ch;
			else
				temp += "_";
		}
		return temp;
	}
	
	private void showAllert(String title, String text) {
		AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
        builder.setTitle(title).setMessage(text)
                                .setCancelable(false)
                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        // do something if OK
                    }
                });/*.setNegativeButton("Cancel",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                // do something if Cancel
                            }
                        });*/
        builder.create().show();
	}
	
	private void setupBtnOk() {
		Button btnOk = (Button)findViewById(R.id.btnOk);
		btnOk.setOnClickListener(new View.OnClickListener() {
			
			@Override
			public void onClick(View v) {
				EditText edtUrl = (EditText)findViewById(R.id.edtUrl);
				ProgressBar prgDownloading = (ProgressBar)findViewById(R.id.prgDownloading);
				prgDownloading.setVisibility(View.VISIBLE);
				
				itemViews.clear();
				
				String path = edtUrl.getText().toString();
				
				path += (path.contains("?") ? "&" : "?") + "json";

				try {
					
					URL url = new URL(path);
					
					HttpURLConnection c;
					c = (HttpURLConnection) url.openConnection();
					c.setRequestMethod("GET");
		            c.setDoOutput(true);
		            c.connect();
					
		            File root = android.os.Environment.getExternalStorageDirectory();
		            String dirname = filterDirname(edtUrl.getText().toString());
		            
		            dirname = root.getAbsolutePath() + "/seakgWebHomeCollection/Data/" + dirname;
		            
		            File dir = new File (dirname);
			        if(dir.exists()==false) {
			            dir.mkdirs();
			        }
			        String filename = dirname + "/collections.json";
			        
			        {
				        File file = new File (filename);
				        if(file.exists())
				        	file.delete();
			        }
			        
			        FileOutputStream f = new FileOutputStream(new File(filename));

		            InputStream in = c.getInputStream();
		            byte[] buffer = new byte[1024];
		            int len1 = 0;
		            while ( (len1 = in.read(buffer)) > 0 ) {
		                f.write(buffer,0, len1);
		            }

		            f.close();
			        
			        File file = new File (filename);
			        if(!file.exists())
			        	return; 

		            String content = FileUtils.readFileToString(file);
		            
					JSONObject obj = new JSONObject(content);
					
				    Iterator<String> keys = obj.keys();
					Iterator<String> iter = keys;
				    while(iter.hasNext()){
				        String key = iter.next().toString();
				        String value = obj.getString(key);
				        itemViews.add(new collectionItemView(key, value));
				    }
				    
				    ArrayAdapter<collectionItemView> adapter = new collectionItemsAdapter(itemViews);
				    ListView list = (ListView)findViewById(R.id.lvwCollections);
				    list.setAdapter(adapter);
				    
					// obj.get("My Films New");

		            // edtText2.setText(content);
					// edtText2.setText(obj.get("My Films New").toString());
		            
			        Toast.makeText(MainActivity.this, filename, Toast.LENGTH_LONG).show();
			        
					
				} catch (MalformedURLException e) {
					showAllert("Error", "Url is invalide.");
					Toast.makeText(MainActivity.this, "", Toast.LENGTH_LONG).show();
					prgDownloading.setVisibility(View.INVISIBLE);
					e.printStackTrace();
				} catch (IOException e) {
					showAllert("Error", "Same error");
					prgDownloading.setVisibility(View.INVISIBLE);
					e.printStackTrace();
				} catch (JSONException e) {
					showAllert("Error", "Json is incorrect.");
					prgDownloading.setVisibility(View.INVISIBLE);
					e.printStackTrace();
				}
				
				
				
				// Toast.makeText(MainActivity.this, "Hello!", Toast.LENGTH_LONG).show();
				
		        
	            
				
				
				/*
				EditText edtSearchText = (EditText)findViewById(R.id.edtSearchText);
				//ProgressBar prgSearching = (ProgressBar)findViewById(R.id.prgSearching);
		        // prgSearching.setVisibility(View.VISIBLE);
				ListView lstSearchResult = (ListView)findViewById(R.id.lstSearchResult);
				
				// lstSearchResult.addView(child)
				
				arrayAdapter = new ArrayAdapter<String>(MainActivity.this, android.R.layout.simple_list_item_1, monthsArray);
				
		        // By using setAdapter method, you plugged the ListView with adapter
				lstSearchResult.setAdapter(arrayAdapter);
				
				Toast.makeText(MainActivity.this, "Search: " + edtSearchText.getText().toString(), Toast.LENGTH_LONG).show();
				*/
		        prgDownloading.setVisibility(View.INVISIBLE);
			}
		});
	}
	
	public class collectionItemsAdapter extends ArrayAdapter<collectionItemView> {

		public collectionItemsAdapter(List<collectionItemView> itemViews) {
			super(MainActivity.this, R.layout.collection_item_view, itemViews);
			
		}

		@Override
		public View getView(int position, View convertView, ViewGroup parent) {
			View itemView = convertView;
			if(itemView == null)
				itemView = getLayoutInflater().inflate(R.layout.collection_item_view, parent, false);
			
			collectionItemView item = MainActivity.this.itemViews.get(position);
			
			TextView name = (TextView)itemView.findViewById(R.id.tvCollectionActivityName);
			TextView url = (TextView)itemView.findViewById(R.id.tvUrl);
			name.setText(item.getName());
			url.setText(item.getUrl());
			
			return itemView;
		}
	}
	
	private void registerClickListView() {
		ListView list = (ListView) findViewById(R.id.lvwCollections);
		list.setOnItemClickListener(new AdapterView.OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> parent, View view, int position,
					long id) {
				
				collectionItemView item = MainActivity.this.itemViews.get(position);
				
				Intent intent = new Intent(MainActivity.this, CollectionActivity.class);
				intent.putExtra("name", item.getName());
				intent.putExtra("url",item.getUrl());
				startActivity(intent);
				
				//Toast.makeText(MainActivity.this, item.getUrl(), Toast.LENGTH_LONG).show();
			}
		});
	};
	
	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.main, menu);
		return true;
	}

}
