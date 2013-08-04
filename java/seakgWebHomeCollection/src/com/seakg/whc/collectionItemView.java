package com.seakg.whc;

public class collectionItemView {
	private String Name;
	private String Url;

	public collectionItemView(String name, String url) {
		super();
		Name = name;
		Url = url;
	}
	public String getName() {
		return Name;
	}
	public void setName(String name) {
		Name = name;
	}
	public String getUrl() {
		return Url;
	}
	public void setUrl(String url) {
		Url = url;
	}

}
