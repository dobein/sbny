fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=500;
_menuOpenDelay=150;
_subOffsetTop=0;
_subOffsetLeft=0;




with(horizStyle=new mm_style()){
bordercolor="#999999";
borderstyle="solid";
borderwidth=1;
fontfamily="arial, tahoma";
fontsize="72%";
fontstyle="normal";
headerbgcolor="#AFD1B5";
headerborder=1;
headercolor="#000099";
offbgcolor="#CFE2D1";
offcolor="#000000";
onbgcolor="#FEFAD2";
onborder="1px solid #999999";
oncolor="#000000";
onsubimage="/ilovehat/admin/on_downboxed.gif";
overbgimage="/ilovehat/admin/backon_beige.gif";
padding=3;
pagebgcolor="#CFE2D1";
pagecolor="#000066";
pageimage="/ilovehat/admin/db_red.gif";
separatoralign="right";
separatorcolor="#999999";
separatorwidth="85%";
subimage="/ilovehat/admin/downboxed.gif";
}

with(vertStyle=new mm_style()){
styleid=1;
bordercolor="#999999";
borderstyle="solid";
borderwidth=1;
fontfamily="arial, tahoma";
fontsize="72%";
fontstyle="normal";
headerbgcolor="#AFD1B5";
headerborder=1;
headercolor="#000099";
image="/ilovehat/admin/18_blank.gif";
imagepadding=3;
menubgimage="/ilovehat/admin/backoff_green.gif";
offbgcolor="transparent";
offcolor="#000000";
onbgcolor="#FEFAD2";
onborder="1px solid #999999";
oncolor="#000000";
onsubimage="/ilovehat/admin/on_13x13_greyboxed.gif";
outfilter="randomdissolve(duration=0.2)";
overfilter="Fade(duration=0.1);Alpha(opacity=95);Shadow(color=#777777', Direction=135, Strength=3)";
padding=3;
pagebgcolor="#CFE2D1";
pagecolor="#000066";
pageimage="/ilovehat/admin/db_red.gif";
separatoralign="right";
separatorcolor="#999999";
separatorpadding=1;
separatorwidth="85%";
subimage="/ilovehat/admin/black_13x13_greyboxed.gif";
menubgcolor="#F5F5F5";
}

with(milonic=new menuname("Sample mainmenu")){
alwaysvisible=1;
left=10;
margin=2;
orientation="horizontal";
style=horizStyle;
top=30;
aI("showmenu=Intro;text=Home;");
aI("showmenu=Sample about;text=Base Setup;");
aI("showmenu=Sample dhtml menu;text=PRODUCT Manager;");
aI("showmenu=Sample products;text=ORDER Manager;");
aI("showmenu=Sample support menu;text=Member Manager;");
aI("showmenu=Sample my milonic;text=Community Manager;");
aI("showmenu=Sample search;text=Customer;");
}
with(milonic=new menuname("Intro")){
margin=3;
style=vertStyle;
top="offset=2";
aI("image=/ilovehat/admin/18_about.gif;text=About Us;url=/aboutus.php;");
aI("image=/ilovehat/admin/18_testimonial.gif;text=Testimonials;url=/testimonials.php;");
aI("image=/ilovehat/admin/18_corporate.gif;text=Distinguished Clients;url=/corp_customers.php;");
aI("image=/ilovehat/admin/18_nonprofit.gif;text=Investing in Non-Profits;url=/nonprofits.php;");
aI("image=/ilovehat/admin/18_where.gif;text=Where Are We;url=/location.php;");
aI("image=/ilovehat/admin/18_contact.gif;text=Contact Us;url=/contactus.php;");
aI("image=/ilovehat/admin/18_privacy.gif;text=Privacy Policy;url=/privacy.php;");
aI("image=/ilovehat/admin/18_license.gif;text=Software Licensing Agreement;url=/license.php;");
}

with(milonic=new menuname("Sample about")){
margin=3;
style=vertStyle;
top="offset=2";
aI("image=/ilovehat/admin/18_about.gif;text=About Us;url=/aboutus.php;");
aI("image=/ilovehat/admin/18_testimonial.gif;text=Testimonials;url=/testimonials.php;");
aI("image=/ilovehat/admin/18_corporate.gif;text=Distinguished Clients;url=/corp_customers.php;");
aI("image=/ilovehat/admin/18_nonprofit.gif;text=Investing in Non-Profits;url=/nonprofits.php;");
aI("image=/ilovehat/admin/18_where.gif;text=Where Are We;url=/location.php;");
aI("image=/ilovehat/admin/18_contact.gif;text=Contact Us;url=/contactus.php;");
aI("image=/ilovehat/admin/18_privacy.gif;text=Privacy Policy;url=/privacy.php;");
aI("image=/ilovehat/admin/18_license.gif;text=Software Licensing Agreement;url=/license.php;");
}

with(milonic=new menuname("Sample dhtml menu")){
margin=3;
style=vertStyle;
top="offset=2";
aI("image=/ilovehat/admin/18_purchase.gif;text=Software Purchasing Pages;url=/cbuy.php;");
aI("image=/ilovehat/admin/18_lic.gif;text=Licensing;url=/licensing.php;");
aI("image=/ilovehat/admin/18_freelic.gif;separatorsize=1;text=Free Licenses;url=/freelicreq.php;");
aI("showmenu=Sample menusamples;text=DHTML Menu Samples;url=/menu.php;");
aI("image=/ilovehat/admin/18_product.gif;text=Product Information;url=/productinfo.php;");
aI("image=/ilovehat/admin/18_integration.gif;text=Page Integration;url=/integration.php;");
aI("image=/ilovehat/admin/18_quick.gif;showmenu=Sample quickref;text=Menu Quick Reference Guides;");
aI("image=/ilovehat/admin/18_version.gif;separatorsize=1;text=Menu Version Information;url=/menuvinfo.php;");
aI("text=Frames Based Menu (version 3);url=/menu/frames/;");
aI("image=/ilovehat/admin/18_converter.gif;text=Version 3 to Version 5.0 Converter;url=/converter.php;");
aI("text=Menu Logos;url=/logos.php;");
aI("image=/ilovehat/admin/18_user.gif;text=List of DHTML Menu users;url=/list/;");
}

drawMenus();

