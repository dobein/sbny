<?
	include "./include/inc_base.php";
	include "./include/inc_top.php";
?>
	<table width="94%" align=center border=0 cellpadding=0 cellspacing=0 >
		<tr bgcolor=#f4f4f4>
			<td height=35 align=left class="title_font">&nbsp;&nbsp;Germanium</td>
		</tr>
	</table>
	<br>

	<table width="94%" align=center border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td width=25% valign=top >
										<table width=95% border=0 cellpadding=0 cellspacing=5 bgcolor=#FFFFFF>
											<?= printGermaniumcategory(); ?>
										</table>
			</td>
			<td width=75% valign=top bgcolor=#FFFFFF>
<script>
function top_round(w,c) {
var top_html;
top_html="<table align=center cellpadding=0 cellspacing=0 border=0 width="+w+">";
top_html+="<tr height=1><td rowspan=4 width=1></td><td rowspan=3 width=1></td>";
top_html+="<td rowspan=2 width=1></td><td width=2></td><td bgcolor="+c+"></td>";
top_html+="<td width=2></td><td rowspan=2 width=1></td><td rowspan=3 width=1></td>";
top_html+="<td rowspan=4 width=1></td></tr><tr height=1><td bgcolor="+c+"></td>";
top_html+="<td bgcolor="+c+"></td><td bgcolor="+c+"></td></tr>";
top_html+="<tr height=1><td bgcolor="+c+"></td><td colspan=3 bgcolor="+c+"></td>";
top_html+="<td bgcolor="+c+"></td></tr><tr height=2><td bgcolor="+c+"></td>";
top_html+="<td colspan=5 bgcolor="+c+"></td><td bgcolor="+c+"></td></tr></table>";
document.write(top_html);
}

function bottom_round(w,c) {
var bottom_html;
bottom_html="<table align=center cellpadding=0 cellspacing=0 border=0 width="+w+">";
bottom_html+="<tr height=2><td rowspan=4 width=1></td><td width=1 bgcolor="+c+"></td><td width=1 bgcolor="+c+"></td>";
bottom_html+="<td width=2 bgcolor="+c+"></td><td bgcolor="+c+"></td><td width=2 bgcolor="+c+"></td>";
bottom_html+="<td width=1 bgcolor="+c+"></td><td width=1 bgcolor="+c+"></td><td rowspan=4 width=1></td></tr>";
bottom_html+="<tr height=1><td rowspan=3></td><td bgcolor="+c+"></td><td colspan=3 bgcolor="+c+"></td>";
bottom_html+="<td bgcolor="+c+"></td><td rowspan=3></td>  </tr><tr height=1><td rowspan=2></td>";
bottom_html+="<td bgcolor="+c+"></td><td bgcolor="+c+"></td><td bgcolor="+c+"></td><td rowspan=2></td></tr>";
bottom_html+="<tr height=1><td></td><td bgcolor="+c+"></td><td></td></tr></table>";
document.write(bottom_html);
}

</script>
<script>
	function lets_go(){

			category1 = document.search_category.main_category.value;
			state1 = document.search_category.state.value;

			location.replace('kin_list.php?category=' + category1 + '&state=' + state1);
		
	}

	function book_view(){
		window.open("book_inside.php","boo","width=900,height=900,scrollbars=1,top=50,left=200");
	}

</script>
<!-- 메인 메뉴 -->
<table width="98%" align=center border="0" cellspacing="0" cellpadding="0" style='border-top: dotted #CCCCCC 1px; border-bottom: dotted #CCCCCC 1px;'>
  <tr bgcolor='#fff5ee'> 
	<td height=23 colspan=3>&nbsp;&nbsp;<b>Related boos to Germanium</b></a></td>
  </tr>
</table>
<br>
<table width="610" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td >
<script>top_round('580','#F9F9F9');</script>
<table width=580 align=center border=0 cellpadding=3 cellspacing=0 bgcolor=#F9F9F9>
	<tr>
		<td height=50>
			<table width=100% border=0 cellpadding=3 cellspacing=0>
				<tr>
					<td colspan=2 height=35>&nbsp;&nbsp;<img src='./img/report.png' align=absmiddle>&nbsp;&nbsp;<b><font color=#4169e1>Germanium_A NEW APPROACH TO IMMUNITY</font></b></td>
				</tr>
				<tr>
					<td width=30% valign=top align=center><img src='./img/book1.gif'></td>
					<td width=70% valign=top>
Format: Paperback, 2nd ed., 36pp.<br>
ISBN: 094450101X<br>
Publisher: Nutrition<br>
Pub. Date: June 1988<br>
Edition Desc: REVISED<br><br>
<img src='./img/zoom_in.png' align=absmiddle> <a href="javascript:book_view()"><font color=red><b>View Inside</b></font></a>
					</td>
				</tr>
				<tr>
					<td colspan=2>
robert, a european naturalist, open minded!, December 31, 1998,<br>
Good book on this Oxygen Catalyst!<br>
Whether you have cancer or lyme disease - this is a must read book! <br>The author has given a good abstract of the international studies on organic germanium and I found it to be very beneficial for me. I highly recommend this book for anyone battling a chronic illness. <br><br>

Also recommended: Eat Right For Your Type - The Secret Life of Plants - The Body Electric - Surviving Lyme Disease Using Alternative Medicine 					
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script>bottom_round('580','#F9F9F9');</script>	
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	<tr>
		<td>
<script>top_round('580','#F9F9F9');</script>
<table width=580 align=center border=0 cellpadding=0 cellspacing=0 bgcolor=#F9F9F9>
	<tr>
		<td height=50>
			<table width=100% border=0 cellpadding=3 cellspacing=0>
				<tr>
					<td colspan=2 height=35>&nbsp;&nbsp;<img src='./img/report.png' align=absmiddle>&nbsp;&nbsp;<b><font color=#4169e1>Chemistry of Organic Germanium, Tin and Lead Compounds</font>
</b></td>
				</tr>
				<tr>
					<td width=30% valign=top align=center><img src='./img/book2.gif'></td>
					<td width=70% valign=top>
Format: Hardcover, 1st ed., 997pp.<br>
ISBN: 0471942073<br>
Publisher: Wiley, John & Sons, Incorporated<br>
Pub. Date: October 1995 				
					</td>
				</tr>
				<tr>
					<td colspan=2>
robert, a european naturalist, open minded!, December 31, 1998,<br>
Good book on this Oxygen Catalyst!<br>
Whether you have cancer or lyme disease - this is a must read book! <br>The author has given a good abstract of the international studies on organic germanium and I found it to be very beneficial for me. I highly recommend this book for anyone battling a chronic illness. <br><br>

Also recommended: Eat Right For Your Type - The Secret Life of Plants - The Body Electric - Surviving Lyme Disease Using Alternative Medicine 					
					</td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
<script>bottom_round('580','#F9F9F9');</script>	
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	<tr>
		<td>
<script>top_round('580','#F9F9F9');</script>
<table width=580 align=center border=0 cellpadding=0 cellspacing=0 bgcolor=#F9F9F9>
	<tr>
		<td height=50>
			<table width=100% border=0 cellpadding=3 cellspacing=0>
				<tr>
					<td colspan=2 height=35>&nbsp;<b><font color=#4169e1>Germanate Glasses</font></b></td>
				</tr>
				<tr>
					<td width=30% valign=top align=center><img src='./img/book3.gif'></td>
					<td width=70% valign=top>
Format: Hardcover, 245pp.<br>
ISBN: 0890065063<br>
Publisher: Artech House, Incorporated<br>
Pub. Date: August 1993 			
					</td>
				</tr>
				<tr>
					<td colspan=2>
Although the glass-forming property of germanium dioxide has been known for a long time, the systematic study of germanate glasses and the glassy properties of germanium oxides has only recently begun. Applications include fiber optics, seals for ultra high vacuums, media lasers, and glasses with specially tailored dispersion properties. Because of the anomalous behavior in their phase diagram, germanate glasses are interesting in themselves for studying the structural peculiarities in isotropic materials. Annotation c. Book News, Inc., Portland, OR (booknews.com)				
					</td>
				</tr>
			</table>		
		</td>
	</tr>
</table>
<script>bottom_round('580','#F9F9F9');</script>	
		</td>
	</tr>
	<tr>
		<td height=10></td>
	</tr>
	<tr>
		<td>
<script>top_round('580','#F9F9F9');</script>
<table width=580 align=center border=0 cellpadding=0 cellspacing=0 bgcolor=#F9F9F9>
	<tr>
		<td height=50>
			<table width=100% border=0 cellpadding=3 cellspacing=0>
				<tr>
					<td colspan=2 height=35>&nbsp;&nbsp;<img src='./img/report.png' align=absmiddle>&nbsp;&nbsp;<b><font color=#4169e1>Germanium Silicon to Physics and Materials, Vol. 5</font></b></td>
				</tr>
				<tr>
					<td width=30% valign=top align=center><img src='./img/book4.gif'></td>
					<td width=70% valign=top>
Format: Hardcover, 1st ed., 444pp.<br>
ISBN: 012752164X<br>
Publisher: Academic Press, Incorporated<br>
Pub. Date: November 1998			
					</td>
				</tr>

			</table>		
		</td>
	</tr>
</table>
<script>bottom_round('580','#F9F9F9');</script>	
		</td>
	</tr>
</table>
<br><br><br>
			</td>
		</tr>
	</table>
	<br>
<?
	include "./include/inc_bottom.php";
?>