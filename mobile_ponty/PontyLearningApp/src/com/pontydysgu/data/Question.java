package com.pontydysgu.data;

/**
 * {
                "id": "9",
                "public": "0",
                "name": "What time did I go to work?",
                "blocked": "1",
                "stack_id": "13",
                "category_id": null,
                "rating": "0",
                "created": "2013-05-13 11:06:43"
            },
 
*/
public class Question {
	private Long id;
	private String name;
	private Long stack_id;
	
	public Long getId() {
		return id;
	}
	public void setId(Long id) {
		this.id = id;
	}
	public String getName() {
		return name;
	}
	public void setName(String name) {
		this.name = name;
	}
	public Long getStack_id() {
		return stack_id;
	}
	public void setStack_id(Long stack_id) {
		this.stack_id = stack_id;
	}
	
	@Override
	public String toString() {
		return this.getClass().getSimpleName()+"["+this.name+" ("+this.id+")]";
	}
}
