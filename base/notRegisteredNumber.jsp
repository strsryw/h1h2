<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean" %>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html" %>
<html:html locale="true">
   <head>
      <title>Not Registered Number</title>
      <html:base/>
   </head>
   <body bgcolor="red">
	   Nomor Batch tidak pernah diinput
	   </br>
   	   <%= session.getAttribute("notRegisteredNumber")%>   
   </body>
      
</html:html>