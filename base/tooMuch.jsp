<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean" %>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html" %>
<html:html locale="true">
   <head>
      <title>tooMuch</title>
      <html:base/>
   </head>
   <body bgcolor="red">
	   Unit terlalu banyak
	   </br>
   	   <%= session.getAttribute("batchNumber")%>   
   </body>
      
</html:html>