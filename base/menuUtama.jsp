<table width="619"><tr><td width="613">
<font face="Verdana" size="2">
<ul id="mb">
	      <logic:iterate id="menuGroup" name="menuGroupList">
	      	<bean:define id="idMenuGroup" name="menuGroup" property="id"/>
	      	<bean:define id="nameMenuGroup" name="menuGroup" property="name"/>
	      	<%pageContext.setAttribute("sIdMenuGroup",idMenuGroup,PageContext.PAGE_SCOPE);%>
	      	<%pageContext.setAttribute("sNamaMenuGroup",nameMenuGroup,PageContext.PAGE_SCOPE);%>

			<li><a href="#"><b>&nbsp;<%=(String)pageContext.getAttribute("sNamaMenuGroup")%>&nbsp;</b></a>
			<ul type="square">
	      	<logic:iterate id="menuGrouping" name="menuGroupingList">
			   	<bean:define id="menuGroupId" name="menuGrouping" property="menuGroupId"/>
	    	  	<bean:define id="menuId" name="menuGrouping" property="menuId"/>
	    	  	<%pageContext.setAttribute("sMenuGroupId",menuGroupId,PageContext.PAGE_SCOPE);%>
	    	  	<%pageContext.setAttribute("sMenuId",menuId,PageContext.PAGE_SCOPE);%>

		      	<logic:equal name="menuGroupId" value="<%=(String)pageContext.getAttribute("sIdMenuGroup")%>">
			      	  <logic:iterate id="menu" name="menuList">
	      				<bean:define id="namaMenu" name="menu" property="namaMenu"/>
          				<bean:define id="hiperLink" name="menu" property="hiperLink"/>
          				<bean:define id="idMenu" name="menu" property="id"/>

			      	  	<logic:equal name="idMenu" value="<%=(String)pageContext.getAttribute("sMenuId")%>">			      	  	
				          	<%pageContext.setAttribute("sNamaMenu",namaMenu,PageContext.PAGE_SCOPE);%>
				          	<%pageContext.setAttribute("sHiperLink",hiperLink,PageContext.PAGE_SCOPE);%>
         					<li><a href="<%=(String)pageContext.getAttribute("sHiperLink")%>"><%=(String)pageContext.getAttribute("sNamaMenu")%></a></li>
				     	</logic:equal>

				      </logic:iterate>
		      	</logic:equal>
	      	</logic:iterate>
      		</ul>
	      	</li>
	      </logic:iterate>
	      </ul> 
 </font>
</td></tr></table>