<%@ taglib uri="/WEB-INF/struts-bean.tld" prefix="bean" %>
<%@ taglib uri="/WEB-INF/struts-html.tld" prefix="html" %>
<%@ taglib uri="/WEB-INF/struts-logic.tld" prefix="logic" %>
<%@ taglib uri="/WEB-INF/struts-form.tld" prefix="form" %>

<html:html locale="true">
   <head>
      <title>
         error
      </title>
      <html:base/>
   </head>
   <body bgcolor="#B9DCFF">
   halaman error..
   <br>pesannya:	<bean:write name="pesan"/>
   </body>
</html:html>