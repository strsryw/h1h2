package web.useCases.base;

public class Row extends DAO.ejb.AbstractData
				implements java.io.Serializable{
	String rowValue="";
	String rowText="";
	public Row(){
	}
	public Row(String aValue){
		this.rowValue=aValue;
	}
	public Row(String aValue,String aText){
		this.rowValue=aValue;
		this.rowText=aText;
	}
	public String getRowValue(){
		return this.rowValue;
	}
	public void setRowValue(String aValue){
		this.rowValue=aValue;
	}
	public String getRowText(){
			return this.rowText;
	}
	public void setRowText(String aText){
			this.rowText=aText;
	}
	public String toString(){
		return "";
	}
}